<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\helper;
use App\Helpers\sms_helper;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
class AdminController extends Controller
{
    public function login(Request $request )
    {
        if($request->email == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.email_required')],200);
        }
        if($request->password == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.password_required')],200);
        }
        $checkuser = User::where('email',$request->email)->where('type','=','1')->first();
        if(!empty($checkuser))
        {
            if(Hash::check($request->password,$checkuser->password)) 
            {
                $checkuser->token = $request['token'];
                $checkuser->save();
                $adminprofile = (new UserController)->getuserprofileobject($checkuser->id);
                return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$adminprofile],200);
            } else {
                return response()->json(['status'=>0,'message'=>trans('messages.email_pass_invalid')],200);
            }
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.email_pass_invalid')],200);
        }
    }
    public function home(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
        }
        $checkuser = User::where('id',$request->user_id)->where('type','=','1')->first();
        if(!empty($checkuser)){

            $todayorders = Order::select('id','order_type','order_number','grand_total','status','transaction_type',\DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as date'))->where('created_at','LIKE','%' .date("Y-m-d") . '%')->orderByDesc('id')->get();

            $total_orders = Order::count('id');
            $cancelled_orders = Order::whereIn('status', array(6,7))->count('id');

            $order_total = Order::where('status', '!=', '6')->where('status', '!=', '7')->sum('grand_total');
            $order_tax = Order::where('status', '!=', '6')->where('status', '!=', '7')->sum('tax_amount');
            
            return response()->json(['status'=>1,'message'=>trans('messages.success'),'todayorders'=>$todayorders,'total_orders'=>$total_orders,'latest_orders'=>count($todayorders),'cancelled_orders'=>$cancelled_orders,'total_earnings'=>$order_total-$order_tax,"appdata"=>helper::appdata()],200);
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }   
    }
    public function getdrivers()
    {
        $getdrivers = User::select('id','name','email','mobile',\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/profile/')."/', profile_image) AS image"))->where('type','3')->where('is_available',1)->orderByDesc('id')->get();
        return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$getdrivers],200);
    }
    public function editprofile(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
        }
        $checkuser = User::where('id',$request->user_id)->where('type','=','1')->first();
        if(!empty($checkuser)){

            if($request->hasFile('image')){
                if($checkuser->profile_image != "unknown.png" && file_exists(env('ASSETSPATHURL').'admin-assets/images/profile/'.$checkuser->profile_image)){
                    unlink(env('ASSETSPATHURL').'admin-assets/images/profile/'.$checkuser->profile_image);
                }
                $image = $request->file('image');
                $image = 'profile-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(env('ASSETSPATHURL').'admin-assets/images/profile', $image);

                $checkuser->profile_image=$image;
                $checkuser->save();
            }

            $checkemail = User::where('email',$request->email)->where('id','!=',$request->user_id)->first();
            $checkmobile = User::where('mobile',$request->mobile)->where('id','!=',$request->user_id)->first();
            if(!empty($checkemail)){
                return response()->json(['status'=>0,'message'=>trans('messages.email_exist')],200);
            }
            if(!empty($checkmobile)){
                return response()->json(['status'=>0,'message'=>trans('messages.mobile_exist')],200);
            }

            $checkuser->name = $request->name;
            $checkuser->email = $request->email;
            $checkuser->mobile = $request->mobile;
            $checkuser->save();
            $adminprofile = (new UserController)->getuserprofileobject($checkuser->id);
            return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$adminprofile],200);
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }
    public function changepassword(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
        }
        $checkuser = User::where('id',$request->user_id)->where('type','=','1')->first();
        if(!empty($checkuser)){
            if($request->old_password == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.old_password_required')],200);
            }
            if($request->new_password == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.new_password_required')],200);
            }
            if($request->old_password == $request->new_password){
                return response()->json(['status'=>0,'message'=>trans('messages.new_password_diffrent')],200);
            }
            if(Hash::check($request->old_password,$checkuser->password))
            {
                $checkuser->password = Hash::make($request->new_password);
                $checkuser->save();
                return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
            }else{
                return response()->json(['status'=>0,'message'=>trans('messages.invalid_password')],200);
            }
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }
    public function forgotPassword(Request $request)
    {
        if($request->email == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.email_required')],200);
        }
        $checkuser = User::where('email',$request->email)->where('type','=','1')->first();
        if(!empty($checkuser)){
            $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 8 );
            $send_pass = helper::send_pass($checkuser->email, $checkuser->name, $password);
            if($send_pass == 1){
                $checkuser->password = Hash::make($password);
                $checkuser->save();
                return response()->json(['status'=>1,'message'=>trans('messages.password_sent')],200);
            }else{
                return response()->json(['status'=>0,'message'=>trans('messages.email_error')],200);
            }
        } else {
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_email')],200);
        }
    }
    public function orderhistory(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
        }
        $checkuser = User::where('id',$request->user_id)->where('type','=','1')->first();
        if(!empty($checkuser)){
            try {
                $getorders = Order::select('id','order_type','order_number','grand_total','status','transaction_type',\DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as date'));
                if ($request->has('start_date') && $request->start_date != "" && $request->has('end_date') && $request->end_date != "") {
                    $getorders = $getorders->whereBetween('order.created_at', [$request->start_date, $request->end_date]);
                }    
                $getorders = $getorders->orderByDesc('id')->get();
                return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$getorders],200);
            } catch (\Throwable $th) {
                return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
            }
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }

    public function updatestatus(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
        }
        $checkuser = User::where('is_available',1)->where('id',$request->user_id)->first();
        if(!empty($checkuser)){
            if($request->order_id == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.order_id_required')],200);
            }
            try {           
                $orderdata = Order::find($request->order_id);
                $user_info = User::find($orderdata->user_id);
                $driver_info = User::find($orderdata->driver_id);
                
                if(!in_array($request->status,array(2,3,4,5,6))){
                    return response()->json(["status"=>0,"message"=>trans('messages.invalid_request')],200);
                }elseif ($request->status == 6 && $orderdata->status == 7) {
                    return response()->json(["status"=>0,"message"=>trans('messages.cancel_by_user')],200);
                }elseif ($request->status == 6 && $orderdata->status == 6) {
                    return response()->json(["status"=>0,"message"=>trans('messages.already_cancelled_by_you')],200);
                }

                $title = "";
                $message_text = "";
                $body = "";
                if ($request->status == "5") {
                    // order ready
                    $title = trans('labels.order_completed');
                    if($orderdata->order_typ == 2){
                        $body = 'Your Order '.$orderdata->order_number.' has been picked up.';
                        $message_text = 'Your Order '.$orderdata->order_number.' has been picked up.';
                    }else{
                        $body = 'Your Order '.$orderdata->order_number.' has been successfully completed.';
                        $message_text = 'Your Order '.$orderdata->order_number.' has been successfully completed.';
                    }
                }
                if ($request->status == "6") {
                    // order cancelled by admin
                    $title = trans('labels.order_cancelled');
                    $body = 'Order '.$orderdata->order_number.' has been cancelled.';
                    $message_text = 'Order '.$orderdata->order_number.' has been cancelled.';

                    if ($orderdata->transaction_type != 1) {

                        $user_info->wallet += $orderdata->grand_total;
                        
                        $transaction = new Transaction;
                        $transaction->user_id = $orderdata->user_id;
                        $transaction->order_id = $orderdata->id;
                        $transaction->order_number = $orderdata->order_number;
                        $transaction->amount = $orderdata->grand_total;
                        $transaction->transaction_id = $orderdata->transaction_id;
                        $transaction->transaction_type = '2';
                        if($transaction->save()){
                            $user_info->save();
                        }
                    }
                }
                if($user_info->is_notification == 1){
                    helper::push_notification($user_info->token,$title,$body,"order",$orderdata->id);
                }
                if($user_info->is_mail == 1){   
                    if(\App\SystemAddons::where('unique_identifier', 'otp')->first() != null && \App\SystemAddons::where('unique_identifier', 'otp')->first()->activated)
                    {
                        sms_helper::order_status_sms($user_info->mobile,$user_info->name,$title,$message_text);
                        
                    }
                    else
                    {
                    helper::order_status_email($user_info->email,$user_info->name,$title,$message_text);
                    }
                }

                $orderdata->status = $request->status;
                $orderdata->save();
                return response()->json(['status'=>1,"message"=>trans('messages.success')],200);
            } catch (\Throwable $th) {
                return response()->json(["status"=>0,"message"=>trans('messages.wrong')],200);
            }
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }
    public function assigndriver(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
        }
        $checkuser = User::where('is_available',1)->where('id',$request->user_id)->first();
        if(!empty($checkuser)){
            if($request->order_id == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.order_id_required')],200);
            }
            if($request->driver_id == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
            }
            try {
                
                $orderdata = Order::find($request->order_id);
                $user_info = User::find($orderdata->user_id);
                $driver_info = User::where('id',$request->driver_id)->where('type','3')->where('is_available',1)->first();
                if(empty($driver_info)){
                    return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
                }
                
                // for user
                $title = trans('messages.driver_assigned_title');
                $body = 'Delivery boy '.$driver_info->name.' has been assigned to your Order '.$orderdata->order_number;
                $message_text = 'Delivery boy '.$driver_info->name.' has been assigned to your Order '.$orderdata->order_number;
                if($user_info->is_notification == 1){
                    helper::push_notification($user_info->token,$title,$body,"order",$orderdata->id);
                }
                if($user_info->is_mail == 1){   
                    if(\App\SystemAddons::where('unique_identifier', 'otp')->first() != null && \App\SystemAddons::where('unique_identifier', 'otp')->first()->activated)
                    {
                        sms_helper::order_status_sms($user_info->mobile,$user_info->name,$title,$message_text);
                    }
                    else
                    {
                        helper::order_status_email($user_info->email,$user_info->name,$title,$message_text);
                    }    
                }
                
                // for driver
                $title = trans('messages.new_order_assigned_title');
                $body = 'New Order '.$orderdata->order_number.' assigned to you';
                $message_text = 'New order '.$orderdata->order_number.' has been assigned to you.';
                $noti = helper::push_notification($driver_info->token,$title,$body,"order",$orderdata->id);
                $status_email = helper::order_status_email($driver_info->email,$driver_info->name,$title,$message_text);
                
                $orderdata->driver_id = $request->driver_id;
                $orderdata->status = 4;
                $orderdata->save();
                return response()->json(['status'=>1,"message"=>trans('messages.success')],200);
            } catch (\Throwable $th) {
                return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
            }
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }  
}