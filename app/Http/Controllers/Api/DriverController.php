<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function login(Request $request)
    {
        if ($request->email == "") {
            return response()->json(['status'=>0,'message'=>trans('messages.email_required')],200);
        }
        if ($request->password == "") {
            return response()->json(['status'=>0,'message'=>trans('messages.password_required')],200);
        }
        $checkdriver = User::where('email', $request->email)->where('is_available', '1')->where('type', '=', '3')->first();
        if (!empty($checkdriver)) {
            if ($checkdriver->is_available == '1') {
                if (Hash::check($request->password, $checkdriver->password)) {
                    $checkdriver->token = $request->token;
                    $checkdriver->save();
                    $data = (new UserController)->getuserprofileobject($checkdriver->id);
                    return response()->json(['status'=>1,'message'=>trans('messages.success'), 'data' => $data], 200);
                } else {
                    return response()->json(['status'=>0,'message'=>trans('messages.email_pass_invalid')],200);
                }
            } else {
                return response()->json(['status'=>0,'message'=>trans('messages.blocked')],200);
            }
        } else {
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_email')],200);
        }
    }
    public function ongoingorder(Request $request)
    {
        if ($request->driver_id == "") {
            return response()->json(['status'=>0,'message'=>trans('messages.user_required')],200);
        }
        $checkdriver = User::where('id', $request->driver_id)->where('is_available', '1')->where('type', '=', '3')->first();
        if (!empty($checkdriver)) {
            $cartdata = OrderDetails::select('order.id', 'order.order_number', 'order.status', 'order.transaction_type', 'order.grand_total', DB::raw('SUM(order_details.qty) AS qty'), DB::raw('DATE_FORMAT(order.created_at, "%d-%m-%Y") as date'))
                ->join('order', 'order_details.order_id', '=', 'order.id')
                ->where('order.driver_id', $request->driver_id)->where('order.status', 4)
                ->groupBy('order_details.order_id')->orderByDesc('order.created_at')
                ->get();

            $completed_order = Order::where('order.status', 5)->where('order.driver_id', $request->driver_id)->count();
            $ongoing_order = Order::where('order.status', 4)->where('order.driver_id', $request->driver_id)->count();

            return response()->json(['status'=>1,'message'=>trans('messages.success'), 'completed_order' => $completed_order, 'ongoing_order' => $ongoing_order, 'data' => $cartdata, "appdata" => helper::appdata()],200);
        } else {
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }
    public function orderhistory(Request $request)
    {
        if ($request->driver_id == "") {
            return response()->json(['status'=>0,'message'=>trans('messages.user_required')],200);
        }
        $checkdriver = User::where('id', $request->driver_id)->where('is_available', '1')->where('type', '=', '3')->first();
        if (!empty($checkdriver)) {
            $cartdata = OrderDetails::select('order.id', 'order.order_number', 'order.status', 'order.transaction_type', 'order.grand_total', DB::raw('SUM(order_details.qty) AS qty'), DB::raw('DATE_FORMAT(order.created_at, "%d-%m-%Y") as date'))
                ->join('order', 'order_details.order_id', '=', 'order.id')
                ->where('order.driver_id', $request->driver_id)->groupBy('order_details.order_id')->orderByDesc('order.created_at')->get();

            $completed_order = Order::where('order.status', 5)->where('order.driver_id', $request->driver_id)->count();
            $ongoing_order = Order::where('order.status', 4)->where('order.driver_id', $request->driver_id)->count();

            return response()->json(['status'=>1,'message'=>trans('messages.success'), 'completed_order' => $completed_order, 'ongoing_order' => $ongoing_order, 'data' => $cartdata], 200);
        } else {
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }
    public function delivered(Request $request)
    {
        if ($request->order_id == "") {
            return response()->json(['status'=>0,'message'=>trans('messages.order_number')],200);
        }
        $orderdata = Order::find($request->order_id);
        if (empty($orderdata)) {
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_order')],200);
        }
        try {
            $user_info = User::find($orderdata->user_id);
            $driver_info = User::find($orderdata->driver_id);

            // for user
            $title = trans('messages.order_delivered');
            $body = 'Your Order ' . $orderdata->order_number . ' has been delivered';
            $message_text = 'Your Order ' . $orderdata->order_number . ' has been delivered';
            if($user_info->is_notification == 1){
                $noti = helper::push_notification($user_info->token,$title,$body,"order",$orderdata->id);
            }
            if($user_info->is_mail == 1){   
                $status_email = helper::order_status_email($user_info->email,$user_info->name,$title,$message_text);
            }

            $orderdata->status = 5;
            $orderdata->save();

            return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
        }
    }
    public function getprofile(Request $request)
    {
        if ($request->driver_id == "") {
            return response()->json(['status'=>0,'message'=>trans('messages.user_required')],200);
        }
        $checkdriver = User::where('id', $request->driver_id)->where('is_available', '1')->where('type', '=', '3')->first();
        if (!empty($checkdriver)) {
            $data = (new UserController)->getuserprofileobject($checkdriver->id);
            return response()->json(['status'=>1,'message'=>trans('messages.success'), 'data' => $data], 200);
        } else {
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }
    public function editprofile(Request $request)
    {
        if ($request->driver_id == "") {
            return response()->json(['status'=>0,'message'=>trans('messages.user_required')],200);
        }
        $checkdriver = User::where('id', $request->driver_id)->where('is_available', '1')->where('type', '=', '3')->first();
        if (!empty($checkdriver)) {

            if ($request->name == "") {
                return response()->json(['status'=>0,'message'=>trans('messages.name_required')],200);
            }
            if (isset($request->image) && $request->hasFile('image')) {
                if($checkdriver->profile_image != "unknown.png" && file_exists(env('ASSETSPATHURL').'admin-assets/images/profile/'.$checkdriver->profile_image)){
                    unlink(env('ASSETSPATHURL').'admin-assets/images/profile/'.$checkdriver->profile_image);
                }
                $image = $request->file('image');
                $image = 'profile-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(env('ASSETSPATHURL').'admin-assets/images/profile', $image);
                $checkdriver->profile_image = $image;
                $checkdriver->save();
            }
            $checkdriver->name = $request->name;
            $checkdriver->save();
            return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
        } else {
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }
    public function changepassword(Request $request)
    {
        if ($request->driver_id == "") {
            return response()->json(['status'=>0,'message'=>trans('messages.user_required')],200);
        }
        $checkdriver = User::where('id', $request->driver_id)->where('is_available', '1')->where('type', '=', '3')->first();
        if (!empty($checkdriver)) {
            if ($request->old_password == "") {
                return response()->json(['status'=>0,'message'=>trans('messages.old_password_required')],200);
            }
            if ($request->new_password == "") {
                return response()->json(['status'=>0,'message'=>trans('messages.new_password_required')],200);
            }
            if ($request->old_password == $request->new_password) {
                return response()->json(['status'=>0,'message'=>trans('messages.new_password_diffrent')],200);
            }
            if (Hash::check($request->old_password, $checkdriver->password)) {
                $checkdriver->password = Hash::make($request->new_password);
                $checkdriver->save();
                return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
            } else {
                return response()->json(['status'=>0,'message'=>trans('messages.old_password_invalid')],200);
            }
        } else {
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }
    public function forgotPassword(Request $request)
    {
        if($request->email == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.email_required')],200);
        }
        $checkdriver = User::where('email', $request->email)->where('is_available', '1')->where('type', '=', '3')->first();
        if (!empty($checkdriver)) {
            $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 8 );
            $pass = Helper::send_pass($checkdriver->email, $checkdriver->name, $password);
            if($pass == 1){
                $checkdriver->password = Hash::make($password);
                $checkdriver->save();
                return response()->json(['status'=>1,'message'=>trans('messages.password_sent')],200);
            }else{
                return response()->json(['status'=>0,'message'=>trans('messages.email_error')],200);
            }
        } else {
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_email')],200);
        }
    }
}
