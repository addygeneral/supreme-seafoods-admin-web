<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Validator;
class OrderotpController extends Controller
{
    public function index(Request $request){
        $getorders = Order::with('user_info','driver_info')->select('order.*')->where('order_from','!=','pos');
        if($request->has('status') && $request->status != ""){
            if($request->status == "processing"){
                $getorders = $getorders->whereNotIn('status',array(5,6,7));
            }
            if($request->status == "completed"){
                $getorders = $getorders->where('status',5);
            }
            if($request->status == "cancelled"){
                $getorders = $getorders->whereIn('status',array(6,7));
            }
        }
        $getorders = $getorders->orderByDesc('id')->get();
        $getdriver = User::where('type','3')->where('is_available',1)->orderByDesc('id')->get();
        $totalprocessing = Order::whereNotIn('status',array(5,6,7))->where('order_from','!=','pos')->count();
        $totalcompleted = Order::where('status',5)->where('order_from','!=','pos')->count();
        $totalcancelled = Order::whereIn('status',array(6,7))->where('order_from','!=','pos')->count();
        return view('admin.orders.index',compact('getorders','getdriver','totalprocessing','totalcompleted','totalcancelled'));
    }

    public function update(Request $request)
    {
        $orderdata = Order::find($request->id);
        $user_info = User::find($orderdata->user_id);
        $driver_info = User::find($orderdata->driver_id);

        $title = "";
        $body = "";
        // if ($request->status == "2") {
        //     // order accepted
        //     $title = trans('labels.order_confirmed');
        //     $body = 'Your Order '.$orderdata->order_number.' has been accepted by Admin';
        // }
        // if ($request->status == "3") {
        //     // order ready
        //     $title = trans('labels.order_ready');
        //     $body = 'Your Order '.$orderdata->order_number.' is ready now.';
        // }
        // if ($request->status == "4") {
        //     // order ready
        //     $title = trans('labels.waiting_pickup');
        //     $body = 'Your Order '.$orderdata->order_number.' is ready now and waiting for pickup';
        // }
        if ($request->status == "5") {
            // order ready
            $title = trans('labels.order_completed');
            if($orderdata->order_typ == 2){
                $body = 'Your Order '.$orderdata->order_number.' has been picked up.';
            }else{
                $body = 'Your Order '.$orderdata->order_number.' has been successfully completed.';
            }
        }
        if ($request->status == "6") {
            // order cancelled by admin
            $title = trans('labels.order_cancelled');
            $body = 'Order '.$orderdata->order_number.' has been cancelled.';

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
            $noti = helper::push_notification($user_info->token,$title,$body,"order",$orderdata->id);
        }

        $orderdata->status = $request->status;
        if ($orderdata->save()) {
            return 1;
        } else {
            return 0;
        }
    }
    public function assign_driver(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'driver_id' => 'required',
        ],[
            "id.required"=>trans('messages.wrong'),
            "driver_id.required"=>trans('messages.select_driver'),
        ]);
        if ($validator->fails()){
            foreach($validator->messages()->getMessages() as $field_name => $messages){
                $errors[$field_name] = $messages;
            }
            return response()->json(['status'=>0,"message"=>trans('messages.wrong'),"errors"=>$errors],200);
        }else{
            $orderdata = Order::find($request->id);
            $user_info = User::find($orderdata->user_id);
            $driver_info = User::find($request->driver_id);

            // for user
            $title = trans('messages.driver_assigned_title');
            $body = 'Delivery boy '.$driver_info->name.' has been assigned to your Order '.$orderdata->order_number;
            $noti = helper::push_notification($user_info->token,$title,$body,"order",$orderdata->id);
            
            // for driver
            $title = trans('messages.new_order_assigned_title');
            $body = 'New Order '.$orderdata->order_number.' assigned to you';
            $noti = helper::push_notification($driver_info->token,$title,$body,"order",$orderdata->id);
            
            $orderdata->driver_id = $request->driver_id;
            $orderdata->status = 4;
            $orderdata->save();
            return response()->json(['status'=>1,"message"=>trans('messages.success')],200);
        }
    }
    public function invoice(Request $request)
    {
        $orderdata = Order::with('user_info','driver_info')->where('order.id', $request->id)->first();
        $ordersdetails = OrderDetails::where('order_details.order_id',$request->id)->get();
        $getdriver = User::where('type','3')->where('is_available',1)->orderByDesc('id')->get();
        return view('admin.orders.invoice',compact('orderdata','ordersdetails','getdriver'));
    }
    public function print(Request $request)
    {
        $orderdata = Order::with('user_info','driver_info')->where('order.id', $request->id)->first();
        $ordersdetails = OrderDetails::where('order_details.order_id',$request->id)->get();
        return view('admin.orders.print',compact('orderdata','ordersdetails'));
    }

    public function get_reports(Request $request)
    {
        $getorders = array();
        $totalprocessing = 0;
        $totalcompleted = 0;
        $totalcancelled = 0;
        $totalearnings = 0;
        if(!empty($request->startdate) && !empty($request->enddate)){
            $getorders = Order::with('user_info','driver_info')->select('order.*')
                ->whereBetween('order.created_at', [$request->startdate, $request->enddate])
                ->orderByDesc('id')
                ->get();
            $totalprocessing = Order::whereNotIn('status',array(5,6,7))->whereBetween('created_at', [$request->startdate, $request->enddate])->count();
            $totalcompleted = Order::where('status',5)->whereBetween('created_at', [$request->startdate, $request->enddate])->count();
            $totalcancelled = Order::whereIn('status',array(6,7))->whereBetween('created_at', [$request->startdate, $request->enddate])->count();
            $totalearnings = Order::where('status','5')->whereBetween('created_at', [$request->startdate, $request->enddate])->sum('grand_total');
        }
        $getdriver = User::where('is_available','1')->where('type','3')->get();
        return view('admin.orders.report',compact('getorders','getdriver','totalprocessing','totalcompleted','totalcancelled','totalearnings'));
    }
}
