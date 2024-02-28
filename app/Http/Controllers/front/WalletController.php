<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Models\Payment;
use App\Models\User;
use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Session;
use Stripe;
class WalletController extends Controller
{
    public function index(Request $request)
    {
        $gettransactions = Transaction::select('id','user_id','order_id','order_number','amount','transaction_id','transaction_type','username','created_at')->where('user_id',Auth::user()->id)->orderByDesc('id')->paginate(10);
        $totalcredited = Transaction::whereIn('transaction_type',array(2,3,4,5,6,7,8,9,10))->sum('amount');
        $totaldebited = Transaction::whereIn('transaction_type',array(1,13))->sum('amount');
        return view('web.wallet.index',compact('gettransactions','totalcredited','totaldebited'));
    }
    public function addform(Request $request)
    {
        $getpaymentmethods = Payment::select('id','environment','payment_name','currency','public_key','secret_key','encryption_key','image')->whereIn('id',array(3,4,5,6,7,8,9,10))->where('is_available',1)->get();
        return view('web.wallet.addmoney', compact('getpaymentmethods'));
    }
    public function addwallet(Request $request)
    {

        if($request->status == 1)
        {
            $userdata = Session::get('userdata');
            $amount = $userdata['grand_total'];
            $transaction_type = $userdata['transaction_type'];
        }
        else
        {
            $amount = $request->amount;
            $transaction_type = $request->transaction_type;
        }

        try {
            $checkuser = User::where('id',Auth::user()->id)->where('is_available',1)->where('type',2)->first();
            if(empty($checkuser)){
                return response()->json(["status"=>0,"message"=>trans('messages.invalid_user')],200);
            }
            if($transaction_type == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.payment_selection_required')],200);
            }
            if($amount == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.enter_amount')],200);
            }
            if($transaction_type == 4)
            {
                try {
                    $stripekey = helper::stripe_data()->secret_key;
                    Stripe\Stripe::setApiKey($stripekey);
                    $token = $request->transaction_id;
                    $charge = Stripe\Charge::create([
                        'amount' => $amount*100,
                        'currency' => helper::stripe_data()->currency,
                        "description" => "SingleReastaurant-WalletRecharge",
                        'source' => $token,
                    ]);
                    $transaction_id = $charge->id;
                } catch (Exception $e) {
                    // return response()->json(['status'=>0,'message'=>$e->getMessage()],200);
                    return response()->json(['status'=>0,'message'=>trans('messages.unable_to_complete_payment')],200);
                }
            }else{
                if($request->transaction_id == ""){
                    return response()->json(["status"=>0,"message"=>trans('messages.enter_transaction_id')],200);
                }
                $transaction_id = $request->transaction_id;
            }
            $checkuser->wallet += $amount;
            $checkuser->save();
            // 3 = added-money-wallet-using- Razorpay 
            // 4 = added-money-wallet-using- Stripe 
            // 5 = added-money-wallet-using- Flutterwave 
            // 6 = added-money-wallet-using- Paystack
            // 7 = added-money-wallet-using- mecadopago
            // 8 = added-money-wallet-using- myfatoorah
            // 9 = added-money-wallet-using- paypal
            // 10 = added-money-wallet-using- toyyibpay
                        
            $transaction = new Transaction();
            $transaction->user_id = $checkuser->id;
            $transaction->transaction_id = $transaction_id;
            $transaction->transaction_type = $transaction_type;
            $transaction->amount = $amount;
            $transaction->save();


           
            if($transaction_type == 7 || $transaction_type == 8 || $transaction_type == 9 || $transaction_type == 10)
            {
                return redirect('wallet')->with('success',trans('messages.add_money_success'));
            }

            return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
        } catch (\Throwable $th) {
            // return response()->json(['status'=>0,'message'=>$th->getMessage()],200);
            return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
        }
    }


    public function addsuccess(Request $request)
    {
        try {

            if($request->has('paymentId'))
            {
                $paymentId = request('paymentId');
                $response = ['status' => 1, 'msg' => 'paid','transaction_id' => $paymentId];  
            }
            if($request->has('payment_id'))
            {    
                $paymentId = request('payment_id');
                $response = ['status' => 1, 'msg' => 'paid','transaction_id' => $paymentId];   
            }

            if($request->has('transaction_id'))
            {
                $paymentId = request('transaction_id');
                $response = ['status' => 1, 'msg' => 'paid','transaction_id' => $paymentId];   
            }
    
        } catch (\Exception $e) {
            $response = ['status' => 0, 'msg' => $e->getMessage()];
        }

        $request = new Request($response);
        return $this->addwallet($request);
    }

    public function addfail(Request $request)
    {
        if(count(request()->all()) > 0)
        {
            return redirect('/wallet')->with('error',trans('messages.unable_to_complete_payment'));
        }
        else
        {
            return redirect('/wallet');
        }   
    }
}
