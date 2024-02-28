<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use App\Helpers\helper;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\User;
use App\Models\Payment;
use App\Models\Time;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;
use Stripe;
class CheckoutotpController extends Controller
{
    public function index(Request $request )
    {
        session()->forget('last_url');
        $getaddresses = Address::select('id','user_id','address_type','address','lat','lang','area','house_no',)->where('user_id',Auth::user()->id)->orderbyDesc('id')->get();
        $getpaymentmethods = Payment::select('id','environment','payment_name','currency','test_public_key','test_secret_key','live_public_key','live_secret_key','encryption_key','image')->where('is_available',1)->get();
        $getcartlist = Cart::where('user_id',Auth::user()->id)->orderByDesc('id')->get();
        if(count($getcartlist) > 0 && session()->has('order_type')){
            return view('web.checkout.checkout',compact('getaddresses','getpaymentmethods','getcartlist'));
        }else{
            return redirect()->back();
        }
    }
    public function isopenclose(Request $request)
    {
        date_default_timezone_set(helper::appdata()->timezone);
        $admin = User::first();
        $date = date('Y/m/d h:i:sa');
        $isopenclose=Time::where('day','=',date('l', strtotime($date)))->first();
        $current_time = DateTime::createFromFormat('H:i a', date("h:i a"));
        $open_time = DateTime::createFromFormat('H:i a', $isopenclose->open_time);
        $close_time = DateTime::createFromFormat('H:i a', $isopenclose->close_time);
        $break_start = DateTime::createFromFormat('H:i a', $isopenclose->break_start);
        $break_end = DateTime::createFromFormat('H:i a', $isopenclose->break_end);
        if ($admin->is_online == 1 && $isopenclose->always_close == "2" &&  ( ($current_time > $open_time && $current_time < $break_start) || ($current_time > $break_end && $current_time < $close_time) )   ) {
            $cartdata = Cart::where('user_id',Auth::user()->id)->get();
            if($request->qty > helper::appdata()->max_order_qty){
                $msg = trans('messages.order_qty_less_then').' : '.helper::appdata()->max_order_qty;
                return response()->json(['status'=>2,'message'=>$msg],200);
            }elseif(count($cartdata)<=0){
                return response()->json(['status'=>2,'message'=>trans('messages.cart_is_empty')],200);
            }elseif($request->order_amount < helper::appdata()->min_order_amount || $request->order_amount > helper::appdata()->max_order_amount ){
                $msg = trans('messages.order_amount_must_between').' '.helper::currency_format(helper::appdata()->min_order_amount).' and '.helper::currency_format(helper::appdata()->max_order_amount);
                return response()->json(['status'=>2,'message'=>$msg],200);
            }else{
                return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
            }
        } else {
           return response()->json(['status'=>0,'message'=>trans('messages.restaurant_closed')],200);
        }
    }
    public function checkdeliveryzone(Request $request)
    {
        if($request->lat == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.select_address')],200);
        }
        if($request->lang == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.select_address')],200);
        }
        $checkzone = helper::checkzone($request->lat,$request->lang);
        if(!$checkzone){
            return response()->json(['status'=>2,'message'=>trans('messages.delivery_not_available')],200);
        }else{
            return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
        }
    }
    public function holduser(Request $request)
    {
        if($request->has('order_type') && $request->order_type != ""){
            if(!in_array($request->order_type,array(1,2))){
                return response()->json(['status'=>0,'message'=>trans('messages.invalid_request')], 200);
            }
            session()->put('order_type',$request->order_type);
        }
        return response()->json(['status'=>1,'message'=>trans('messages.success')], 200);
    }
    public function placeorder(Request $request)
    {
        try {
            date_default_timezone_set(helper::appdata()->timezone);
            $checkuser = User::where('is_available',1)->where('id',Auth::user()->id)->first();
            if(!empty($checkuser)){
                $cartdata = Cart::where('user_id',Auth::user()->id)->get();
                if(count($cartdata)<=0){
                    return response()->json(['status'=>0,'message'=>trans('messages.cart_is_empty')],200);
                }
                $order_number = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 10)), 0, 10);

                if($request->order_type == ""){
                    return response()->json(['status'=>0,'message'=>trans('messages.order_type_required')],200);
                }
                if($request->transaction_type == ""){
                    return response()->json(['status'=>0,'message'=>trans('messages.transaction_type_required')],200);
                }
                if($request->transaction_type != 1 && $request->transaction_type != 2 && $request->transaction_type != 4){
                    if($request->transaction_id == ""){
                        return response()->json(['status'=>0,'message'=>trans('messages.transaction_id_required')],200);
                    }
                }
                $transaction_id = $request->transaction_id;

                if($request->grand_total == ""){
                    return response()->json(["status"=>0,"message"=>trans('messages.grand_total_required')],200);
                }
                
                if ($request->order_type == "2") {
                    $address = "";
                    $address_type = "";
                    $lat = "";
                    $lang = "";
                    $house_no = "";
                    $area = "";
                } else {
                    if($request->address_type == ""){
                        return response()->json(["status"=>0,"message"=>trans('messages.address_type_required')],200);
                    }
                    if($request->address == ""){
                        return response()->json(["status"=>0,"message"=>trans('messages.address_required')],200);
                    }
                    if($request->lat == ""){
                        return response()->json(["status"=>0,"message"=>trans('messages.select_address')],200);
                    }
                    if($request->lang == ""){
                        return response()->json(["status"=>0,"message"=>trans('messages.select_address')],200);
                    }
                    if($request->house_no == ""){
                        return response()->json(["status"=>0,"message"=>trans('messages.house_no_required')],200);
                    }
                    $address = $request->address;
                    $address_type = $request->address_type;
                    $lat = $request->lat;
                    $lang = $request->lang;
                    $house_no = $request->house_no;
                    $area = $request->area;
                }

                if($request->transaction_type == 2)
                {
                    if($checkuser->wallet == "" || ($checkuser->wallet < $request->grand_total) ){
                        return response()->json(['status'=>0,'message'=>trans('messages.insufficient_wallet')],200);
                    }
                }
                if($request->transaction_type == 4)
                {
                    if (helper::stripe_data()->environment == "1") {
                        $stripekey = helper::stripe_data()->test_secret_key;
                    } else {
                        $stripekey = helper::stripe_data()->live_secret_key;
                    }
                    try {
                        Stripe\Stripe::setApiKey($stripekey);
                        $token = $request->transaction_id;
                        $charge = Stripe\Charge::create([
                            'amount' => $request->grand_total*100,
                            'currency' => helper::stripe_data()->currency,
                            "description" => "SingleReastaurant-OrderPayment",
                            'source' => $token,
                        ]);
                        $transaction_id = $charge->id;
                    } catch (Exception $e) {
                        // return response()->json(['status'=>0,'message'=>$e->getMessage()],200);
                        return response()->json(['status'=>0,'message'=>trans('messages.unable_to_complete_payment')],200);
                    }
                }

                $order = new Order;
                $order->order_number = $order_number;
                $order->user_id = $checkuser->id;
                $order->order_type = $request->order_type;

                $order->address_type = $address_type;
                $order->address = $address;
                $order->house_no = $house_no;
                $order->area = $area;
                $order->lat = $lat;
                $order->lang = $lang;

                if(session()->has('discount_data')){
                    $order->offer_code = session()->get('discount_data')['offer_code'];
                    $order->discount_amount = helper::number_format(session()->get('discount_data')['offer_amount']);
                }else{
                    $order->offer_code = "";
                    $order->discount_amount = helper::number_format(0);
                }

                $order->transaction_type = $request->transaction_type;
                if($request->transaction_type != 1 && $request->transaction_type != 2){
                    $order->transaction_id = $transaction_id;
                }
                
                $order->tax_amount = helper::number_format($request->tax_amount);
                $order->delivery_charge = helper::number_format($request->delivery_charge);
                $order->grand_total = helper::number_format($request->grand_total);

                $order->order_notes = $request->order_notes;
                $order->order_from = "web";

                $order->status = 1;
                
                if($order->save()){

                    if($request->transaction_type == 2){
                        $checkuser->wallet = $checkuser->wallet - $request->grand_total;

                        $transaction = new Transaction();
                        $transaction->user_id = $checkuser->id;
                        $transaction->order_id = $order->id;
                        $transaction->order_number = $order_number;
                        $transaction->transaction_id = $transaction_id;
                        $transaction->transaction_type = 1;
                        $transaction->amount = helper::number_format($request->grand_total);
                        if($transaction->save()){
                            $checkuser->save();
                        }
                    }

                    $cartdata = Cart::where('user_id',$checkuser->id)->get();
                    foreach($cartdata as $cart){
                        $od = new OrderDetails();
                        $od->order_id = $order->id;
                        $od->user_id = $checkuser->id;
                        $od->item_id = $cart->item_id;
                        $od->item_name = $cart->item_name;
                        $od->item_type = $cart->item_type;
                        $od->item_image = $cart->item_image;
                        $od->tax = $cart->tax;
                        $od->qty = $cart->qty;
                        $od->item_price = $cart->item_price;
                        $od->addons_id = $cart->addons_id;
                        $od->addons_name = $cart->addons_name;
                        $od->addons_price = $cart->addons_price;
                        $od->addons_total_price = $cart->addons_total_price;
                        $od->variation_id = $cart->variation_id;
                        $od->variation = $cart->variation;
                        $od->save();
                    }
                    Cart::where('user_id',$checkuser->id)->delete();

                    if($checkuser->is_notification == 1){
                        $title = trans('labels.order_placed');
                        $body = "Your Order ".$order_number." has been placed.";
                        $noti = helper::push_notification($checkuser->token,$title,$body,"order",$order->id);
                    }
                    session()->forget('discount_data');
                    session()->forget('order_type');
                    return response()->json(['status'=>1,'message'=>trans('messages.success'),'order_id'=>$order_number],200);
                }else{
                    return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
                }
            }else{
                return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
            }
        } catch (\Throwable $th) {
            // return response()->json(['status'=>0,'message'=>$th->getMessage()],200);
            return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
        }
    }
}