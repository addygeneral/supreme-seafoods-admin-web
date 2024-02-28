<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OTPConfiguration;
class OTPConfigurationController extends Controller
{
    public function index()
    {
        $twilioconfigurations = OTPConfiguration::where('name','twilio')->first();
        $msg91configurations = OTPConfiguration::where('name','msg91')->first();
        return view('otp-settings',compact('twilioconfigurations','msg91configurations'));
    }
    public function update(Request $request)
    {
        $payment = OTPConfiguration::find($request->id);
        $payment->twilio_sid = $request->twilio_sid;
        $payment->twilio_auth_token = $request->twilio_auth_token;
        $payment->twilio_mobile_number = $request->twilio_mobile_number;
        $payment->msg_authkey = $request->msg_authkey;
        $payment->msg_template_id = $request->msg_template_id;
        $payment->status = $request->status;
        $payment->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
}
