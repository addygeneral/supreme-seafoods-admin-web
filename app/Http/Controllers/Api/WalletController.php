<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Helpers\helper;
use Stripe;
class WalletController extends Controller
{
    public function addwallet(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.enter_user_id')],200);
        }
        $checkuser = User::where('id',$request->user_id)->where('is_available',1)->first();
        if(empty($checkuser)){
            return response()->json(["status"=>0,"message"=>trans('messages.invalid_user')],200);
        }
        if($request->transaction_type == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.enter_transaction_type')],200);
        }
        if($request->amount == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.enter_amount')],200);
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
                $data = $stripe->tokens->create([
                    'card' => [
                        'number' => $request->card_number,
                        'exp_month' => $request->card_exp_month,
                        'exp_year' => $request->card_exp_year,
                        'cvc' => $request->card_cvc,
                    ],
                ]);
                Stripe\Stripe::setApiKey($stripekey);
                $payment = Stripe\Charge::create ([
                    "amount" => $request->amount * 100,
                    "currency" => helper::stripe_data()->currency,
                    "source" => $data->id,
                    "description" => "SingleReastaurant-WalletRecharge",
                ]);
                $transaction_id = $payment->id;
            } catch (Exception $e) {
                return response()->json(['status'=>0,'message'=>trans('messages.unable_to_complete_payment')],200);
            }
        }else{
            if($request->transaction_id == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.enter_transaction_id')],200);
            }
            $transaction_id = $request->transaction_id;
        }
        $checkuser->wallet += $request->amount;
        $checkuser->save();
        // 3 = added-money-wallet-using- Razorpay 
        // 4 = added-money-wallet-using- Stripe 
        // 5 = added-money-wallet-using- Flutterwave 
        // 6 = added-money-wallet-using- Paystack
        $transaction = new Transaction();
        $transaction->user_id = $request->user_id;
        $transaction->transaction_id = $transaction_id;
        $transaction->transaction_type = $request->transaction_type;
        $transaction->amount = $request->amount;
        $transaction->save();
        return response()->json(['status'=>1,'message'=>trans('messages.success'),"total_wallet"=>$checkuser->wallet],200);
    }
    public function transactions(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.enter_user_id')],200);
        }
        $transactions = Transaction::select('id','user_id','order_id','order_number','amount','transaction_id','transaction_type','username',\DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as date'))->where('user_id',$request->user_id)->orderByDesc('id')->get();
        
        return response()->json(["status"=>1,"message"=>trans('messages.success'),'transactions'=>$transactions],200);
    }
}
