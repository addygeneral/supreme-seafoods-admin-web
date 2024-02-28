<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Models\Order;
use App\Models\User;
use App\Models\Transaction;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class OrderController extends Controller
{
    public function index(Request $request)
    {   
       
        $getorders=Order::select('order.id','order.order_from','order.order_type','order.order_number','order.grand_total','order.status','order.transaction_type', 'order.created_at')
                ->where('order.user_id',Auth::user()->id);
            if($request->has('type') && $request->type == "completed"){
                $getorders = $getorders->where('status',5);
            }else if($request->has('type') && $request->type == "cancelled"){
                $getorders = $getorders->whereIn('status',array(6,7));
            }else{
                // processing
                $getorders = $getorders->whereIn('status',array(1,2,3,4));
            }
        $getorders = $getorders->where('order.order_from','!=','pos')->orderByDesc('id')->paginate(10);
        $totalprocessing = Order::whereIn('status',array(1,2,3,4))->where('order_from','!=','pos')->where('user_id',Auth::user()->id)->count();
        $totalcompleted = Order::where('status',5)->where('order_from','!=','pos')->where('user_id',Auth::user()->id)->count();
        $totalcancelled = Order::whereIn('status',array(6,7))->where('order_from','!=','pos')->where('user_id',Auth::user()->id)->count();
        return view('web.orders.orders', compact('getorders','totalprocessing','totalcompleted','totalcancelled'));
    }
    public function statusupdate(Request $request)
    {
        $orderdata = Order::where('order_number',$request->id)->first();
        if(Auth::user())
        {
            $user_info = User::find(Auth::user()->id);
        }    
        if(!empty($orderdata) && $orderdata->status == 1){
            
            if(Auth::user())
            {
                if($orderdata->transaction_type != 1){
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
            // TO ADMIN
            $title = trans('labels.order_cancelled');
            $admin_message_text = 'Order '.$orderdata->order_number.' has been cancelled by User.';
            $admindata = User::select('id','name','email','mobile')->where('type',1)->first();

            $status_email = helper::order_status_email($admindata->email,$admindata->name,$title,$admin_message_text);
            
            
            // order cancelled by User
            $orderdata->status = 7;
            if ($orderdata->save()) {
                return 1;
            } else {
                return 0;
            }
        }else{
            return 0;   
        }
    }
    public function orderdetails(Request $request)
    {
        $orderdata = Order::with('driver_info')->where('order_number', $request->order_number)->first();
        if(!empty($orderdata)){
            $ordersdetails = OrderDetails::where('order_id',$orderdata->id)->orderByDesc('id')->get();
            return view('web.orders.orderdetails',compact('orderdata','ordersdetails'));
        }else{
            return redirect()->back()->with('error',trans('messages.wrong'));
        }
    }
}
