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
use App\Models\About;
use App\Models\Time;
use Session;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Stripe;

use function PHPSTORM_META\elementType;

class CheckoutController extends Controller
{

    public function index(Request $request )
    {
        session()->forget('last_url');

        if(session()->get('order_type') == 2)
        {
            session()->forget('addressdata');
        }
        if(Auth::user())
        {
            $getaddresses = Address::select('id','user_id','address_type','address','lat','lang','area','house_no')->where('user_id',Auth::user()->id)->orderbyDesc('id')->get();
            $getcartlist = Cart::where('user_id',Auth::user()->id)->orderByDesc('id')->get();
            $getpaymentmethods = Payment::select('id','environment','payment_name','currency','public_key','secret_key','encryption_key','image')->where('is_available',1)->where('is_activate','1')->get();
     
        }
        else
        {
            $getaddresses = array();
            $getcartlist = Cart::where('session_id',Session::getId())->orderByDesc('id')->get();
            $getpaymentmethods = Payment::select('id','environment','payment_name','currency','public_key','secret_key','encryption_key','image')->where('is_available',1)->where('payment_name','!=','Wallet')->where('is_activate','1')->get();
     
        }
            
        if(count($getcartlist) > 0 && session()->has('order_type')){
            return view('web.checkout.checkout',compact('getaddresses','getpaymentmethods','getcartlist'));
        }else{
            return redirect()->back();
        }
    }
    public function isopenclose(Request $request)
    {
        
        if(@helper::appdata()->timezone != ""){
            date_default_timezone_set(helper::appdata()->timezone);
        }
        $admin = User::first();
        $date = date('Y/m/d h:i:sa');
        $isopenclose=Time::where('day','=',date('l', strtotime($date)))->first();
        $current_time = DateTime::createFromFormat('H:i a', date("h:i a"));
        $open_time = DateTime::createFromFormat('H:i a', $isopenclose->open_time);
        $close_time = DateTime::createFromFormat('H:i a', $isopenclose->close_time);
        $break_start = DateTime::createFromFormat('H:i a', $isopenclose->break_start);
        $break_end = DateTime::createFromFormat('H:i a', $isopenclose->break_end);
        if ($admin->is_online == 1 && $isopenclose->always_close == "2" &&  ( ($current_time > $open_time && $current_time < $break_start) || ($current_time > $break_end && $current_time < $close_time) )   ) {
            if(Auth::user())
            {
                $cartdata = Cart::where('user_id',Auth::user()->id)->get();
            }
            else
            {
                $cartdata = Cart::where('session_id',Session::getId())->get();
            }
            
            if($request->qty > helper::appdata()->max_order_qty){
                $msg = trans('messages.order_qty_less_then').' : '.helper::appdata()->max_order_qty;
                return response()->json(['status'=>2,'message'=>$msg],200);
            }elseif(count($cartdata)<=0){
                return response()->json(['status'=>2,'message'=>trans('messages.cart_is_empty')],200);
            }elseif($request->order_amount < helper::appdata()->min_order_amount || $request->order_amount > helper::appdata()->max_order_amount ){
                $msg = trans('messages.order_amount_must_between').' '.helper::currency_format(helper::appdata()->min_order_amount).' and '.helper::currency_format(helper::appdata()->max_order_amount);
                return response()->json(['status'=>2,'message'=>$msg],200);
            }else{
               
                $getsettings = About::first();

                if($getsettings->login_required == 1)
                {
                    if(Auth::user())
                    { 
                       
                        return response()->json(['status'=>3,'message'=>trans('messages.success')],200);
                    }
                    else
                    {
                       
                        return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
                    }
                }
                else
                {
                    return response()->json(['status'=>3,'message'=>trans('messages.success')],200);
                }
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
     
        
        if($checkzone == null){
            return response()->json(['status'=>2,'message'=>trans('messages.delivery_not_available')],200);
        }else{
            return response()->json(['status'=>1,'message'=>trans('messages.success'),'delivery_charge'=>$checkzone],200);
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

       $address = $request->address;
       $address_type = $request->address_type;
       $lat = $request->lat;
       $lang = $request->lang;
       $house_no = $request->house_no;
       $delivery_charge = $request->delivery_charge;
       $name = $request->name;
       $area = "";
       $email = $request->email;
       $mobile = $request->mobile;
       $order_type = $request->order_type;
       $transaction_type = $request->transaction_type;
       $grand_total = $request->grand_total;
       $tax_amount = $request->tax_amount;
       $order_notes = $request->order_notes;
       $transaction_id = $request->transaction_id;
     
     if($request->status == 1)
     {
       $userdata = Session::get('userdata');
       $address = $userdata['address'];
       $address_type = $userdata['address_type'];
       $lat = $userdata['lat'];
       $lang = $userdata['lang'];
       $house_no = $userdata['house_no'];
       $delivery_charge = $userdata['delivery_charge'];
       $name =$userdata['name'];
       $email = $userdata['email'];
       $mobile = $userdata['mobile'];
       $order_type = $userdata['order_type'];
       $transaction_type = $userdata['transaction_type'];
       $grand_total = $userdata['grand_total'];
       $tax_amount = $userdata['tax_amount'];
       $order_notes = $userdata['order_notes'];

       $transaction_id = $request->paymentId;
       
  
     }
    
        try {
            date_default_timezone_set(helper::appdata()->timezone);
          
                if(Auth::user())
                {
                    $cartdata = Cart::where('user_id',Auth::user()->id)->get();
                }
                else
                {
                    $cartdata = Cart::where('session_id',Session::getId())->get();
                }
        
                if(count($cartdata)<=0){
                    return response()->json(['status'=>0,'message'=>trans('messages.cart_is_empty')],200);
                }
                $order_number = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 10)), 0, 10);
                if($order_type == ""){
                    return response()->json(['status'=>0,'message'=>trans('messages.order_type_required')],200);
                }
                if($transaction_type == ""){
                    return response()->json(['status'=>0,'message'=>trans('messages.transaction_type_required')],200);
                }
                if($transaction_type != 1 && $transaction_type != 2 && $transaction_type != 8 && $transaction_type != 4){
                    if($transaction_id == ""){
                        return response()->json(['status'=>0,'message'=>trans('messages.transaction_id_required')],200);
                    }
                }
                
                if($grand_total == ""){
                    return response()->json(["status"=>0,"message"=>trans('messages.grand_total_required')],200);
                }
                if ($order_type == "1") {
                    if(Auth::user())
                    {
                            if($address_type == ""){
                                return response()->json(["status"=>0,"message"=>trans('messages.address_type_required')],200);
                            }
                    }
                            if($address == ""){
                                return response()->json(["status"=>0,"message"=>trans('messages.address_required')],200);
                            }

                            if($lat == ""){
                                return response()->json(["status"=>0,"message"=>trans('messages.select_address')],200);
                            }
        
                            if($lang == ""){
                                return response()->json(["status"=>0,"message"=>trans('messages.select_address')],200);
                            }
                            if($house_no == ""){
                                return response()->json(["status"=>0,"message"=>trans('messages.house_no_required')],200);
                            }

                } 

                if(Auth::user())
                {
                    $checkuser = User::where('is_available',1)->where('id',Auth::user()->id)->first();
                    if($request->transaction_type == 2)
                    {
                        if($checkuser->wallet == "" || ($checkuser->wallet < $request->grand_total) ){
                            return response()->json(['status'=>0,'message'=>trans('messages.insufficient_wallet')],200);
                        }
                    }
                }
                else
                {
                    if($name == "")
                    {
                        return response()->json(["status"=>0,"message"=>trans('messages.name_required')],200);
                    }
                    if($email == "")
                    {
                        return response()->json(["status"=>0,"message"=>trans('messages.email_required')],200);
                    }
                    if($mobile == "")
                    {
                        return response()->json(["status"=>0,"message"=>trans('messages.mobile_required')],200);
                    }
                }
                
                if($transaction_type == 4)
                {
                    try {
                        $stripekey = helper::stripe_data()->secret_key;
                        Stripe\Stripe::setApiKey($stripekey);
                        $token = $transaction_id;
                        $charge = Stripe\Charge::create([
                            'amount' => $grand_total*100,
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
                $order->user_id = @$checkuser->id;
                $order->order_type = $order_type;
                $order->address_type = $address_type;
                $order->address = $address;
                $order->house_no = $house_no;
                $order->area = $area;
                $order->lat = $lat;
                $order->lang = $lang;
                $order->name = $name;
                $order->email = $email;
                $order->mobile = $mobile;
                if(session()->has('discount_data')){
                    $order->offer_code = session()->get('discount_data')['offer_code'];
                    $order->discount_amount = helper::number_format(session()->get('discount_data')['offer_amount']);
                }else{
                    $order->offer_code = "";
                    $order->discount_amount = helper::number_format(0);
                }
                $order->transaction_type = $transaction_type;
                if($transaction_type != 1 && $transaction_type != 2){
                    $order->transaction_id = $transaction_id;
                }
                $order->tax_amount = helper::number_format($tax_amount);
                $order->delivery_charge = helper::number_format($delivery_charge);
                $order->grand_total = helper::number_format($grand_total);
                $order->order_notes = $order_notes;
                $order->order_from = "web";
                $order->status = 1;
                if($order->save()){
                    if($request->transaction_type == 2){
                        $checkuser->wallet = $checkuser->wallet - $grand_total;
                        $transaction = new Transaction();
                        $transaction->user_id = $checkuser->id;
                        $transaction->order_id = $order->id;
                        $transaction->order_number = $order_number;
                        $transaction->transaction_id = $transaction_id;
                        $transaction->transaction_type = 1;
                        $transaction->amount = helper::number_format($grand_total);
                        if($transaction->save()){
                            $checkuser->save();
                        }
                    }
                    if(Auth::user())
                    {
                        $cartdata = Cart::where('user_id',$checkuser->id)->get();
                    }
                    else
                    {
                        $cartdata = Cart::where('session_id',Session::getId())->get();
                    }
                    
                    foreach($cartdata as $cart){
                        $od = new OrderDetails();
                        $od->order_id = $order->id;
                        $od->user_id = @$checkuser->id;
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
                    if(Auth::user())
                    {
                        Cart::where('user_id',$checkuser->id)->delete();
                        if($checkuser->is_notification == 1){
                            $title = trans('labels.order_placed');
                            $body = "Your Order ".$order_number." has been placed.";
                            $noti = helper::push_notification($checkuser->token,$title,$body,"order",$order->id);
                        }
                        $orderdata = Order::where('id',$order->id)->first();
                        $itemdata = OrderDetails::where('order_id',$order->id)->get();
                        if($checkuser->is_mail == 1){   
                            $invoice_helper = helper::create_order_invoice($checkuser->email,$checkuser->name,$order_number,$orderdata,$itemdata);
                        }
                    }
                    else
                    {
                        Cart::where('session_id',Session::getId())->delete();
                        
                            $title = trans('labels.order_placed');
                            $body = "Your Order ".$order_number." has been placed.";
                            $noti = helper::push_notification(125,$title,$body,"order",$order->id);
                     
                        $orderdata = Order::where('id',$order->id)->first();
                        $itemdata = OrderDetails::where('order_id',$order->id)->get();
                    }
                    
                    $admindata = User::select('id','name','email','mobile')->where('type',1)->first();

                    if(Auth::user())
                    {
                        $admin_invoice = helper::create_order_invoice($admindata->email,$checkuser->name,$order_number,$orderdata,$itemdata);
                    }
                    else
                    {
                        $admin_invoice = helper::create_order_invoice($admindata->email,$name,$order_number,$orderdata,$itemdata);
                    }

                    session()->forget('discount_data');
                    
                    if($transaction_type == 8 || $transaction_type == 7 || $transaction_type == 9 || $transaction_type == 10)
                    {
                        session()->forget('userdata');
                        return redirect('/orders-'.$order_number)->with('success',trans('messages.order_placed_note'));
                    }
                    return response()->json(['status'=>1,'message'=>trans('messages.success'),'order_id'=>$order_number],200);
                }else{
                    return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
                }
            
        } catch (\Throwable $th) {
           
            return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
        }
    }


    public function paymentsuccess(Request $request) {
        try {
            
            if($request->has('paymentId'))
            {
                $paymentId = request('paymentId');
                $response = ['status' => 1, 'msg' => 'paid','paymentId' => $paymentId];  
            }
            if($request->has('payment_id'))
            {    
                $paymentId = request('payment_id');
                $response = ['status' => 1, 'msg' => 'paid','paymentId' => $paymentId];   
            }

            if($request->has('transaction_id'))
            {
                $paymentId = request('transaction_id');
                $response = ['status' => 1, 'msg' => 'paid','paymentId' => $paymentId];   
            }
    
        } catch (\Exception $e) {
            $response = ['status' => 0, 'msg' => $e->getMessage()];
        }

        $request = new Request($response);
        return $this->placeorder($request);
    }

    public function paymentfail() 
    {
        if(count(request()->all()) > 0)
        {
            return redirect('/checkout')->with('error',trans('messages.unable_to_complete_payment'));
        }
        else
        {
            return redirect('/checkout');
        }     
    }    

}
