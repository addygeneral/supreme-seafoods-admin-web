<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
class PaymentController extends Controller
{
    public function index(){
        $getpayment = Payment::where('is_activate','1')->get();
        return view('admin.payment.payment',compact('getpayment'));
    }
    public function update(Request $request)
    {
        $transaction_type = $request->transaction_type;
        $is_available = $request->is_available;
        $currency = $request->currency;
        $environment = $request->environment;
        $public_key = $request->public_key;
        $secret_key = $request->secret_key;
        foreach($transaction_type as $key => $no){
            $data = Payment::find($no);
            if(!empty($is_available)){
                if(isset($is_available[$no])){
                    $data->is_available = $is_available[$no];
                }else{
                    $data->is_available = 2;
                }
            }else{
                $data->is_available = 2;
            }
            if(in_array($no,[3,4,5,6,7,8,9,10])){
                $data->environment = $environment[$no];
                if($transaction_type != 7 || $transaction_type != 8){
                $data->public_key = $public_key[$no];
                }
                $data->secret_key = $secret_key[$no];
                $data->currency = $currency[$no];
            }
            if($transaction_type == 5){
                $data->encryption_key = $request->encryption_key;
            }
        
            $data->save();
        }
        if($request->hasFile('cod_image')){
            $pay_data = Payment::find(1);
            dd($pay_data);
            if($pay_data->image != "cod.png" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image)){
                unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('cod_image')->getClientOriginalExtension();
            $request->file('cod_image')->move(env('ASSETSPATHURL').'admin-assets/images/about/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('wallet_image')){
            $pay_data = Payment::find(2);
            if($pay_data->image != "wallet.png" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image)){
                unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('wallet_image')->getClientOriginalExtension();
            $request->file('wallet_image')->move(env('ASSETSPATHURL').'admin-assets/images/about/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('razorpay_image')){
            $pay_data = Payment::find(3);
            if($pay_data->image != "razorpay.png" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image)){
                unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('razorpay_image')->getClientOriginalExtension();
            $request->file('razorpay_image')->move(env('ASSETSPATHURL').'admin-assets/images/about/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('stripe_image')){
            $pay_data = Payment::find(4);
            if($pay_data->image != "stripe.png" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image)){
                unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('stripe_image')->getClientOriginalExtension();
            $request->file('stripe_image')->move(env('ASSETSPATHURL').'admin-assets/images/about/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('flutterwave_image')){
            $pay_data = Payment::find(5);
            if($pay_data->image != "flutterwave.png" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image)){
                unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('flutterwave_image')->getClientOriginalExtension();
            $request->file('flutterwave_image')->move(env('ASSETSPATHURL').'admin-assets/images/about/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('paystack_image')){
            $pay_data = Payment::find(6);
            if($pay_data->image != "paystck.png" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image)){
                unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('paystack_image')->getClientOriginalExtension();
            $request->file('paystack_image')->move(env('ASSETSPATHURL').'admin-assets/images/about/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('mercadopago_image')){
            $pay_data = Payment::find(7);
            if($pay_data->image != "mercadopago.png" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image)){
                unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('mercadopago_image')->getClientOriginalExtension();
            $request->file('mercadopago_image')->move(env('ASSETSPATHURL').'admin-assets/images/about/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }

        if($request->hasFile('myfatoorah_image')){
            $pay_data = Payment::find(8);
            if($pay_data->image != "myfatoorah.png" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image)){
                unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('myfatoorah_image')->getClientOriginalExtension();
            $request->file('myfatoorah_image')->move(env('ASSETSPATHURL').'admin-assets/images/about/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('paypal_image')){
            $pay_data = Payment::find(9);
            if($pay_data->image != "paypal.png" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image)){
                unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('paypal_image')->getClientOriginalExtension();
            $request->file('paypal_image')->move(env('ASSETSPATHURL').'admin-assets/images/about/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }

        if($request->hasFile('toyyibpay_image')){
            $pay_data = Payment::find(10);
            if($pay_data->image != "toyyibpay.png" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image)){
                unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('toyyibpay_image')->getClientOriginalExtension();
            $request->file('toyyibpay_image')->move(env('ASSETSPATHURL').'admin-assets/images/about/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }
}
