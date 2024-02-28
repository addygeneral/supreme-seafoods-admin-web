<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderDetails;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Stripe;

class CheckoutController extends Controller
{
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
            return response()->json(['status'=>1,'message'=>trans('messages.success'),'delivery_charge'=>$checkzone],200);
        }
    }
    public function paymentmethodlist(Request $request)
    {
        
        if($request->user_id != null)
        {
            if($request->type == "order"){
                $pmdata = Payment::select('id','environment','payment_name','currency','public_key','secret_key','encryption_key',DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/about/')."/', image) AS image"))->where('is_available',1)->where('is_activate','1')->orderBy('id')->get();
            }
            if($request->type == "wallet"){
                $pmdata = Payment::select('id','environment','payment_name','currency','public_key','secret_key','encryption_key',DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/about/')."/', image) AS image"))->where('is_available',1)->where('is_activate','1')->where('payment_name','!=','cod')->where('payment_name','!=','wallet')->orderBy('id')->get();
            }
            if($request->type != "order" && $request->type != "wallet"){
                return response()->json(['status'=>1,'message'=>trans('messages.invalid_request')],200);
            }
            if(!empty($pmdata)){
                $total = User::select('wallet')->where('id',$request->user_id)->first();
                $total == "" ? $total = 0 : $total = $total->wallet;
                return response()->json(['status'=>1,'message'=>trans('messages.success'),'total_wallet'=>$total,'paymentmethods'=>$pmdata],200);
            }else{
                return response()->json(['status'=>1,'message'=>trans('messages.not_available')],200);
            }
        }
        else
        {
            if($request->type == "order"){
                $pmdata = Payment::select('id','environment','payment_name','currency','public_key','secret_key','encryption_key',DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/about/')."/', image) AS image"))->where('is_available',1)->where('payment_name','!=','wallet')->orderBy('id')->get();
            }
            if($request->type == "wallet"){
                $pmdata = Payment::select('id','environment','payment_name','currency','public_key','secret_key','encryption_key',DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/about/')."/', image) AS image"))->where('is_available',1)->where('payment_name','!=','cod')->where('payment_name','!=','wallet')->orderBy('id')->get();
            }
            if($request->type != "order" && $request->type != "wallet"){
                return response()->json(['status'=>1,'message'=>trans('messages.invalid_request')],200);
            }
            if(!empty($pmdata)){
                return response()->json(['status'=>1,'message'=>trans('messages.success'),'total_wallet'=>0,'paymentmethods'=>$pmdata],200);
            }else{
                return response()->json(['status'=>1,'message'=>trans('messages.not_available')],200);
            }
        }
            
        
    }
    public function summary(Request $request)
    {
        if($request->user_id == ""){
            $cartdata=Cart::select('*',DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/item/')."/', item_image) AS item_image"))->where('is_available','1')->where('session_id',$request->session_id)->get();
        }
        else
        {
            $cartdata=Cart::select('*',DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/item/')."/', item_image) AS item_image"))->where('is_available','1')->where('user_id',$request->user_id)->get();
        }
        
        
        $data = array();
        $totaltax = 0;
        $order_total = 0;
        foreach ($cartdata as $value) {
            
            $tax = number_format(($value->item_price*$value->qty)*$value->tax/100,2);
            $total_price = ($value->item_price+$value->addons_total_price)*$value->qty;

        	$data[] = array(
        	    "id" => $value->id,
        	    "item_id" => $value->item_id,
        	    "item_name" => $value->item_name,
        	    "item_type" => $value->item_type,
                "variation_id" => $value->variation_id == "" ? "" : $value->variation_id,
                "variation" => $value->variation == "" ? "" : $value->variation,
                "addons_id" => $value->addons_id == "" ? "" : $value->addons_id,
                "addons_name" => $value->addons_name == "" ? "" : $value->addons_name,
                "addons_price" => $value->addons_price == "" ? "" : $value->addons_price,
                "addons_total_price" => $value->addons_total_price,
                'item_image' => $value->item_image,
        	    "item_price" => $value->item_price,
        	    "qty" => $value->qty,
                "total_price" => $total_price,
        	);
            $totaltax += (float)$tax;
            $order_total += (float)$total_price;
        }
        $summery = array(
        	'order_total' => $order_total,
        	'tax' => $totaltax,
        );
        return response()->json(['status'=>1,'message'=>trans('messages.success'),'summery'=>$summery,'data'=>$data],200);
    }
    public function order(Request $request)
    {
        date_default_timezone_set(helper::appdata()->timezone);
        
            if($request->user_id == "")
            {
                $cartdata = Cart::where('session_id',$request->session_id)->get();
            }
            else
            {
                $cartdata = Cart::where('user_id',$request->user_id)->get();
            }
            
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
                $name = $request->name;
                $email = $request->email;
                $mobile = $request->mobile;

            } else {
                if($request->user_id != null)
                {
                    if($request->address_type == ""){
                        return response()->json(["status"=>0,"message"=>trans('messages.address_type_required')],200);
                    }
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
                $name = $request->name;
                $email = $request->email;
                $mobile = $request->mobile;

            }
            if($request->user_id != null)
            {
                $checkuser = User::where('is_available',1)->where('id',$request->user_id)->first();
                if($request->transaction_type == 2)
                {
                    if($checkuser->wallet == "" || ($checkuser->wallet < $request->grand_total) ){
                        return response()->json(['status'=>0,'message'=>trans('messages.insufficient_wallet')],200);
                    }
                }
            }
            
            if($request->user_id == null)
            {
                if($request->name == ""){
                    return response()->json(["status"=>0,"message"=>trans('messages.name_required')],200);
                }
                if($request->email == ""){
                    return response()->json(["status"=>0,"message"=>trans('messages.email_required')],200);
                }

                if($request->mobile == ""){
                    return response()->json(["status"=>0,"message"=>trans('messages.mobile_required')],200);
                }
            }

            if($request->transaction_type == 4)
            {
                if($request->card_number == ""){
                    return response()->json(["status"=>0,"message"=>trans('messages.card_number')],200);
                }
                if($request->card_exp_month == ""){
                    return response()->json(["status"=>0,"message"=>trans('messages.card_exp_month')],200);
                }
                if($request->card_exp_year == ""){
                    return response()->json(["status"=>0,"message"=>trans('messages.card_exp_year')],200);
                }
                if($request->card_cvc == ""){
                    return response()->json(["status"=>0,"message"=>trans('messages.card_cvc')],200);
                }

                try {
                    $stripekey = helper::stripe_data()->secret_key;
                    $stripe = new \Stripe\StripeClient($stripekey);
                    $gettoken = $stripe->tokens->create([
                        'card' => [
                            'number' => $request->card_number,
                            'exp_month' => $request->card_exp_month,
                            'exp_year' => $request->card_exp_year,
                            'cvc' => $request->card_cvc,
                        ],
                    ]);
                    Stripe\Stripe::setApiKey($stripekey);
                    $payment = Stripe\Charge::create ([
                        "amount" => $request->grand_total * 100,
                        "currency" => helper::stripe_data()->currency,
                        "source" => $gettoken->id,
                        "description" => "SingleReastaurant-OrderPayment",
                    ]);
                    $transaction_id = $payment->id;
                } catch (Exception $e) {
                    return response()->json(['status'=>0,'message'=>trans('messages.unable_to_complete_payment')],200);
                }
            }

            $order = new Order;
            $order->order_number = $order_number;
            $order->user_id = @$request->user_id;
            $order->order_type = $request->order_type;
            $order->name = $name;
            $order->email = $email;
            $order->mobile = $mobile;

            $order->address_type = $address_type;
            $order->address = $address;
            $order->house_no = $house_no;
            $order->area = $area;
            $order->lat = $lat;
            $order->lang = $lang;

            $order->offer_code = $request->offer_code;
            $order->discount_amount = $request->discount_amount;

            $order->transaction_type = $request->transaction_type;
            if($request->transaction_type != 1 && $request->transaction_type != 2){
                $order->transaction_id = $transaction_id;
            }
            
            $order->tax_amount = $request->tax_amount;
            $order->delivery_charge = $request->delivery_charge;
            $order->grand_total = $request->grand_total;

            $order->order_notes = $request->order_notes;
            $order->order_from = $request->order_from;

            $order->status = 1;
            
            if($order->save()){

                if($request->transaction_type == 2){
                    $checkuser->wallet = $checkuser->wallet - $request->grand_total;
                    $checkuser->save();

                    $transaction = new Transaction();
                    $transaction->user_id = $request->user_id;
                    $transaction->order_id = $order->id;
                    $transaction->order_number = $order_number;
                    $transaction->transaction_id = $transaction_id;
                    $transaction->transaction_type = 1;
                    $transaction->amount = $request->grand_total;
                    $transaction->save();
                }
                if($request->user_id != null)
                {
                    $cartdata = Cart::where('user_id',$request->user_id)->get();
                }
                else
                {
                    $cartdata = Cart::where('session_id',$request->session_id)->get();
                }
               
                foreach($cartdata as $cart){
                    $od = new OrderDetails();
                    $od->order_id = $order->id;
                    $od->user_id = @$request->user_id;
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

                $admindata = User::select('id','name','email','mobile')->where('type',1)->first();

                if($request->user_id != null)
                {
                    Cart::where('user_id',$request->user_id)->delete();

                    if($checkuser->is_notification == 1){
                        $title = trans('labels.order_placed');
                        $body = "Your Order ".$order_number." has been placed.";
                        $noti = helper::push_notification($checkuser->token,$title,$body,"order",$order->id);
                    }

                    $orderdata = Order::where('id',$order->id)->first();
                    $itemdata = OrderDetails::where('order_id',$order->id)->get();
                    if($checkuser->is_mail == 1){   
                        if(\App\SystemAddons::where('unique_identifier', 'otp')->first() != null && \App\SystemAddons::where('unique_identifier', 'otp')->first()->activated == 0)
                        {
                            $invoice_helper = helper::create_order_invoice($checkuser->email,$checkuser->name,$order_number,$orderdata,$itemdata);
                        }
                    }
                    $admin_invoice = helper::create_order_invoice($admindata->email,$checkuser->name,$order_number,$orderdata,$itemdata);
                }
                else
                {
                    Cart::where('session_id',$request->session_id)->delete();

                        $title = trans('labels.order_placed');
                        $body = "Your Order ".$order_number." has been placed.";
                        $noti = helper::push_notification(261,$title,$body,"order",$order->id);
                  
                        $orderdata = Order::where('id',$order->id)->first();
                        $itemdata = OrderDetails::where('order_id',$order->id)->get();
                   
                        $admin_invoice = helper::create_order_invoice($admindata->email,$request->name,$order_number,$orderdata,$itemdata);
                }

                return response()->json(['status'=>1,'message'=>trans('messages.success'),"order_id"=>$order->id],200);            
            }else{
                return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
            }
        
    }
    public function orderhistory(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
        }
        $checkuser = User::where('is_available',1)->where('id',$request->user_id)->first();
        if(!empty($checkuser)){
            if($request->type == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.invalid_request')],200);
            }
            if(!in_array($request->type,array(1,2,3))){
                return response()->json(["status"=>0,"message"=>trans('messages.invalid_request')],200);
            }
            $data=Order::select('order.id','order.order_type','order.order_number','order.grand_total','order.status','order.transaction_type',DB::raw('DATE_FORMAT(order.created_at, "%d-%m-%Y") as date'))->where('order.user_id',$request->user_id)->orderByDesc('order.id');
            if($request->has('type') && $request->type == 1){
                // processing
                $data = $data->whereIn('status',array(1,2,3,4));
            }
            if($request->has('type') && $request->type == 2){
                // completed
                $data = $data->where('status',5);
            }
            if($request->has('type') && $request->type == 3){
                // cancelled
                $data = $data->whereIn('status',array(6,7));
            }
            $data = $data->get();
            return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$data],200);
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }
    public function getorderdetails(Request $request)
    {
        if($request->order_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.order_id_required')],200);
        }
        $checkorderdata = Order::with('driver_info','user_info')->select('order.*',DB::raw('DATE_FORMAT(order.created_at, "%d-%m-%Y") as order_date'))->where('order.id',$request['order_id'])->first();
        if(!empty($checkorderdata)){

            $orderdetails=OrderDetails::select('order_details.*')
            ->join('item','order_details.item_id','=','item.id')
            ->join('order','order_details.order_id','=','order.id')
            ->where('order_details.order_id',$request->order_id)->get();
            $order_total = 0;
            $cdata = array();
            foreach ($orderdetails as $value) {
                $total_price = ($value->item_price+$value->addons_total_price)*$value->qty;
                $cdata[] = array(
                    "id" => $value->id,
                    "item_id" => $value->item_id,
                    "item_name" => $value->item_name,
                    "item_type" => $value->item_type,
                    "item_image" => Helper::image_path($value->item_image),
                    "addons_id" => $value->addons_id == "" ? "" :$value->addons_id,
                    "addons_name" => $value->addons_name == "" ? "" :$value->addons_name,
                    "addons_price" => $value->addons_price == "" ? "" :$value->addons_price,
                    "addons_total_price" => $value->addons_total_price,
                    'variation_id' => $value->variation_id == "" ? "" :$value->variation_id,
                    'variation' => $value->variation == "" ? "" :$value->variation,
                    "item_price" => $value->item_price,
                    "qty" => $value->qty,
                    "total_price" => $total_price,
                );
                $order_total += (float)$total_price;
            }

            $summery = array(
                'id' => $checkorderdata->id,
                'order_number' => $checkorderdata->order_number,
                'status' => $checkorderdata->status,
                'order_type' => $checkorderdata->order_type,

                "address_type" => $checkorderdata->address_type == "" ? "" : $checkorderdata->address_type,
                "address" => $checkorderdata->address == "" ? "" : $checkorderdata->address,
                "house_no" => $checkorderdata->house_no == "" ? "" : $checkorderdata->house_no,
                "area" => $checkorderdata->area == "" ? "" : $checkorderdata->area,
                "lat" => $checkorderdata->lat == "" ? "" : $checkorderdata->lat,
                "lang" => $checkorderdata->lang == "" ? "" : $checkorderdata->lang,

                'transaction_type' => $checkorderdata->transaction_type,
                'transaction_id' => $checkorderdata->transaction_id == "" ? "" : $checkorderdata->transaction_id,
                'offer_code' => $checkorderdata->offer_code == "" ? "" : $checkorderdata->offer_code,
                'order_notes' => $checkorderdata->order_notes == "" ? "" : $checkorderdata->order_notes,
                'discount_amount' => $checkorderdata->discount_amount == "" ? 0 : $checkorderdata->discount_amount,
                'delivery_charge' => $checkorderdata->delivery_charge,
                'date' => $checkorderdata->order_date,
                'order_total' => $order_total,
                'tax' => $checkorderdata->tax_amount,
                'grand_total' => $checkorderdata->grand_total,
            );
            $driver_info = array(
                "id"=>"",
                "name"=>"",
                "email"=>"",
                "mobile"=>"",
                "token"=>"",
                "profile_image"=>"",
            );
            if($checkorderdata->driver_info != ""){
                $driver_info = $checkorderdata->driver_info;
            }
            return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>@$cdata,'driver_info'=>$driver_info,"user_info"=>$checkorderdata->user_info,'summery'=>$summery],200);
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_order')],200);
        }
    }
    public function ordercancel(Request $request)
    {
        if($request->order_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.order_number')],200);
        }
        $orderdata = Order::where('order.id',$request['order_id'])->first();
        if(!empty($orderdata)){
            
            if($orderdata->status == 1){   
                
                $checkuser = User::find($orderdata->user_id);

                if ($orderdata->transaction_type != 1) {
                    $checkuser->wallet += $orderdata->grand_total;

                    $transaction = new Transaction;
                    $transaction->user_id = $orderdata->user_id;
                    $transaction->order_id = $request->order_id;
                    $transaction->order_number = $orderdata->order_number;
                    $transaction->amount = $orderdata->grand_total;
                    $transaction->transaction_id = $orderdata->transaction_id;
                    $transaction->transaction_type = '2';
                    if($transaction->save()){
                        $checkuser->save();
                    }
                }

                // TO USER
                $title = trans('labels.order_cancelled');
                $body = 'Order '.$orderdata->order_number.' has been cancelled.';
                if($checkuser->is_notification == 1){
                    $noti = helper::push_notification($checkuser->token,$title,$body,"order",$request->order_id);
                }

                // TO ADMIN
                $admin_message_text = 'Order '.$orderdata->order_number.' has been cancelled by User.';
                $admindata = User::select('id','name','email','mobile')->where('type',1)->first();
                $status_email = helper::order_status_email($admindata->email,$admindata->name,$title,$admin_message_text);
                
                $orderdata->status = 7;
                $orderdata->save();
                return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
            }else{
                if($orderdata->status == 6){
                    return response()->json(['status'=>0,'message'=>trans('messages.already_cancelled_by_admin')],200);
                }else if($orderdata->status == 7){
                    return response()->json(['status'=>0,'message'=>trans('messages.already_cancelled_by_you')],200);
                }else{
                    return response()->json(['status'=>0,'message'=>trans('messages.already_acceped_by_admin')],200);
                }
            }
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_order')],200);
        }
    }
}
