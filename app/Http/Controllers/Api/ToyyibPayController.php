<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Session;

class ToyyibPayController extends Controller
{
    public function toyyibpayrequest(Request $request)
    {
      try{

        if($request->name == "")
        {
            $name = " ";   
        }
        else
        {
            $name = $request->name;
        }

        if($request->mobile == "")
        {
            $mobile = " ";
        }
        else
        {
            $mobile = $request->mobile;
        }

        if($request->email == "")
        {
            $email = " ";
        }
        else
        {
            $email = $request->email;
        }

        if($request->grand_total == "")
        {
           return response()->json(['status' => 0, 'message' => trans('messages.grand_total_required')], 200);
        }

            $userdata = [
                "name" => $request->name,
                "email" => $request->email,
                "mobile" => $request->mobile,
                "address_type" => $request->address_type,
                "order_type" => $request->order_type,
                "delivery_charge" => $request->delivery_charge,
                "grand_total" => $request->grand_total,
                "tax_amount" => $request->tax_amount,
                "address" => $request->address,
                "house_no" => $request->house_no,
                "lat" => $request->lat,
                "lang" => $request->lang,
                "order_notes" => $request->order_notes,
                "transaction_type" => $request->transaction_type,
            ];

            Session::put('userdata', $userdata);


            $grandtotal = $request->grand_total;
            $successurl = "https://www.google.com/";
            $failurl = "https://www.facebook.com/";


            $gettoken = Payment::where('payment_name','ToyyibPay')->first();
            $some_data = array(
                'userSecretKey'=>$gettoken->secret_key,
                'categoryCode'=>$gettoken->public_key,
                'billName'=>$name,
                'billDescription'=>"Order Purchase",
                'billPriceSetting'=>1,
                'billPayorInfo'=>0,
                'billAmount'=>$grandtotal*100,
                'billReturnUrl'=>$successurl,
                'billCallbackUrl'=>$successurl,
                'billExternalReferenceNo' => '',
                'billTo'=>'',
                'billEmail'=>'',
                'billPhone'=>'',
                'billSplitPayment'=>0,
                'billSplitPaymentArgs'=>'',
                'billPaymentChannel'=>0,
                'billContentEmail'=>'Thank you for using our platform!',
                'billChargeToCustomer'=>""
            );  
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/createBill/');  
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

            $result = curl_exec($curl);
            curl_close($curl);
            $obj = json_decode($result);
            
            if($gettoken->environment == 1) {
                $redirecturl = "https://dev.toyyibpay.com/".$obj[0]->BillCode;
                $billcode = $obj[0]->BillCode;
            } else {
                $redirecturl = "https://toyyibpay.com/".$obj[0]->BillCode;
                $billcode = $obj[0]->BillCode;
            }

            return response()->json(['status' => 1, 'message' => trans('messages.success'), 'redirecturl' => $redirecturl , 'successurl' => $successurl, 'failureurl' => $failurl, 'billcode' => $billcode], 200);
       }
       catch(Exception $e)
       {
         return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
       }
    }
}
