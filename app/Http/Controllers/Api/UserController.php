<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Helpers\sms_helper;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Contact;
use App\Models\OTPConfiguration;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function login(Request $request )
    {
        if(\App\SystemAddons::where('unique_identifier', 'otp')->first() != null && \App\SystemAddons::where('unique_identifier', 'otp')->first()->activated)
        {
            if($request->mobile == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.mobile_required')],200);
            }
            $checkuser = User::where('mobile',$request->mobile)->where('type',2)->first();
        }
        else
        {
            if($request->email == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.email_required')],200);
            }
            if($request->password == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.password_required')],200);
            }

            $checkuser = User::where('email',$request->email)->where('type',2)->first();
        }

        if(!empty($checkuser))
        {
            if(\App\SystemAddons::where('unique_identifier', 'otp')->first() != null && \App\SystemAddons::where('unique_identifier', 'otp')->first()->activated)
            { 
                if($checkuser->is_available == 1)
                {
                    $otp = rand ( 100000 , 999999 );
                    $send_otp = sms_helper::verificationsms($checkuser->mobile,$otp);
                    if($send_otp == 1){
                        $checkuser->otp = $otp;
                        $checkuser->save();
                        return response()->json(['status'=>2,'message'=>trans('messages.unverified'),'email'=>$checkuser->mobile,'otp'=>$otp],200);
                    }else{
                        return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
                    }
                }else{
                    return response()->json(['status'=>0,'message'=>trans('messages.blocked')],200);
                }
            }
            else
            {
                if(Hash::check($request->password,$checkuser->password)) 
                {
                    if($checkuser->is_available == '1') 
                    {
                        if($checkuser->is_verified == '1')
                        {
                            $checkuser->token = $request['token'];
                            $checkuser->save();
                            $userprofile = $this->getuserprofileobject($checkuser->id);
                            return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$userprofile],200);
                        }else{
                            $otp = rand ( 100000 , 999999 );
                            $verification = helper::verificationemail($request->email,$otp);
                            if($verification == 1){
                                $checkuser->otp = $otp;
                                $checkuser->save();
                                return response()->json(['status'=>2,'message'=>trans('messages.unverified'),'email'=>$checkuser->email,'otp'=>$otp],200);
                            }else{
                                return response()->json(['status'=>0,'message'=>trans('messages.email_error')],200);
                            }
                        }
                    }else{
                        return response()->json(['status'=>0,'message'=>trans('messages.blocked')],200);
                    }
                } else {
                    return response()->json(['status'=>0,'message'=>trans('messages.email_pass_invalid')],200);
                }
            }
            
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.email_pass_invalid')],200);
        }
    }
    public function otpverify(Request $request )
    {

        if(\App\SystemAddons::where('unique_identifier', 'otp')->first() != null && \App\SystemAddons::where('unique_identifier', 'otp')->first()->activated)
        {
            if($request->mobile == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.mobile_required')],200);
            }

            $checkuser=User::where('mobile',$request->mobile)->first();
        } 
        else
        {
            if($request->email == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.email_required')],200);
            }
            if($request->token == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.token_required')],200);
            }

            $checkuser=User::where('email',$request->email)->first();
        }

        if($request->otp == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.otp_required')],200);
        }
       
       
        if (!empty($checkuser)) {

            $is_valid_otp = 2;


            if(\App\SystemAddons::where('unique_identifier', 'otp')->first() != null && \App\SystemAddons::where('unique_identifier', 'otp')->first()->activated)
            {
                $getconfiguration = OTPConfiguration::where('status',1)->first();
                if ($getconfiguration->name == "msg91") {
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.msg91.com/api/v5/otp/verify?authkey=".$getconfiguration->msg_authkey."&mobile=".$request->mobile."&otp=".$request->otp."",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                    ));
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                    $response = json_decode($response);
                    $is_valid_otp = $response->type == "error" ? 2 : 1;
                } else {
                    $is_valid_otp = $checkuser->otp != $request->otp ? 2 : 1;
                }
            }

            if ($checkuser->otp == $request->otp || $is_valid_otp == 1) {
                $checkuser->otp = null;
                $checkuser->is_verified = 1;
                $checkuser->token = $request->token;
                $checkuser->save();

                // CHECK_USER_HAS_REFFERAL_USER
                if ($checkuser->user_id > 0) {
                    $checkreferral = User::find($checkuser->user_id);
                    $UpdateWalletDetails = User::where('id', $checkreferral->id)->update(['wallet'=>$checkreferral->wallet + $checkuser->referral_amount]);
                    $referral_wallet = new Transaction;
                    $referral_wallet->user_id = $checkreferral->id;
                    $referral_wallet->amount = $checkuser->referral_amount;
                    $referral_wallet->transaction_type = 11;
                    $referral_wallet->username = $checkuser->name;
                    $referral_wallet->save();

                    $UpdateWallet = User::where('id', $checkuser->id)->update(['wallet'=>$checkuser->referral_amount,'user_id'=>'','referral_amount'=>0]);
                    $new_user = new Transaction;
                    $new_user->user_id = $checkuser->id;
                    $new_user->amount = $checkuser->referral_amount;
                    $new_user->transaction_type = 11;
                    $new_user->username = $checkreferral->name;
                    $new_user->save();

                    $title = trans('labels.referral_earning');
                    $body = 'Your friend "'.$checkuser->name.'" has used your referral code to register with Our Restaurant. You have earned "'.helper::currency_format(helper::appdata()->referral_amount).'" referral amount in your wallet.';
                    helper::push_notification($checkreferral->token,$title,$body,"wallet","");
                    $referralmessage='Your friend "'.$checkuser->name.'" has used your referral code to register with Restaurant User. You have earned "'.helper::appdata()->currency.''.number_format(helper::appdata()->referral_amount,2).'" referral amount in your wallet.';
                    helper::referral($checkreferral->email,$checkuser->name,$checkreferral->name,$referralmessage);
                }

                $userprofile = $this->getuserprofileobject($checkuser->id);
                return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$userprofile],200);
            } else {
                return response()->json(["status"=>0,"message"=>trans('messages.invalid_otp')],200);
            }  
        } else {
            return response()->json(["status"=>0,"message"=>trans('messages.invalid_email')],200);
        }  
    }
    public function resendotp(Request $request )
    {
        if(\App\SystemAddons::where('unique_identifier', 'otp')->first() != null && \App\SystemAddons::where('unique_identifier', 'otp')->first()->activated)
        {
            if($request->mobile == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.mobile_required')],200);
            }
            $checkuser=User::where('mobile',$request->mobile)->first();
        }
        else
        {
            if($request->email == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.email_required')],200);
            }
            $checkuser=User::where('email',$request->email)->first();
        }
       
        if (!empty($checkuser)) {
            $otp = rand ( 100000 , 999999 );
            if(\App\SystemAddons::where('unique_identifier', 'otp')->first() != null && \App\SystemAddons::where('unique_identifier', 'otp')->first()->activated)
            {
                $verification = sms_helper::verificationsms($checkuser->mobile,$otp);
            }
            else
            {
                $verification = helper::verificationemail($request->email,$otp);
            }
            if($verification == 1){
                $checkuser->otp = $otp;
                $checkuser->is_verified = 2;
                $checkuser->save();
                return response()->json(['status'=>1,'message'=>trans('messages.email_sent'),'otp'=>$otp],200);
            }else{
                return response()->json(['status'=>0,'message'=>trans('messages.email_error')],200);
            }
        } else {
            return response()->json(["status"=>0,"message"=>trans('messages.invalid_email')],200);
        }  
    }
    public function editprofile(Request $request )
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
        }
        $checkuser = User::find($request->user_id);
        if(!empty($checkuser))
        {
            if($request->name == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.name_required')],200);
            }
            if($request->hasFile('image')){
                if($checkuser->profile_image != "unknown.png" && file_exists(env('ASSETSPATHURL').'admin-assets/images/profile/'.$checkuser->profile_image)){
                    unlink(env('ASSETSPATHURL').'admin-assets/images/profile/'.$checkuser->profile_image);
                }
                $image = 'profile-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(env('ASSETSPATHURL').'admin-assets/images/profile', $image);
                $checkuser->profile_image = $image;
                $checkuser->save();
            }
            $checkuser->name = $request->name;
            $checkuser->save();
            $userprofile = $this->getuserprofileobject($checkuser->id);
            return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$userprofile],200);
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }
    public function changepassword(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
        }
        if($request->old_password == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.old_password_required')],200);
        }
        if($request->new_password == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.new_password_required')],200);
        }
        if($request->old_password == $request->new_password){
            return response()->json(['status'=>0,'message'=>trans('messages.new_password_diffrent')],200);
        }
        $checkuser = User::find($request->user_id);
        if(!empty($checkuser)){
            if(Hash::check($request->old_password,$checkuser->password)){
                $checkuser->password = Hash::make($request->new_password);
                $checkuser->save();
                return response()->json(['status'=>1,'message'=>trans('messages.update')],200);
            }else{
                return response()->json(['status'=>0,'message'=>trans('messages.old_password_invalid')],200);
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
        $checkuser = User::where('email',$request['email'])->where('type',2)->first();
        if(empty($checkuser)){
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_email')],200);
        } elseif ($checkuser->google_id != "" || $checkuser->facebook_id != "") {
            return response()->json(['status'=>0,'message'=>trans('messages.social_login')],200);
        } else {
            $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 8 );
            $pass = Helper::send_pass($checkuser->email, $checkuser->name, $password);
            if($pass == 1){
                $checkuser->password = Hash::make($password);
                $checkuser->save();
                return response()->json(['status'=>1,'message'=>trans('messages.password_sent')],200);
            }else{
                return response()->json(['status'=>0,'message'=>trans('messages.email_error')],200);
            }
        }
    }
    public function isnotification(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
        }
        $checkuser = User::where('id',$request->user_id)->where('is_available','1')->first();
        if(!empty($checkuser)){
            if($request->has('notification_status') && $request->notification_status != ""){
                $checkuser->is_notification = $request->notification_status;
                $checkuser->save();
            }
            if($request->has('mail_status') && $request->mail_status != ""){
                $checkuser->is_mail = $request->mail_status;
                $checkuser->save();
            }
            return response()->json(['status'=>1,'message'=>trans('messages.success'),"notification_status"=>$checkuser->is_notification,"mail_status"=>$checkuser->is_mail],200);
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }
    public function contact(Request $request)
    {
        if($request->firstname == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.first_name_required')],200);
        }
        if($request->lastname == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.last_name_required')],200);
        }
        if($request->email == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.email_required')],200);
        }
        if($request->message == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.message_required')],200);
        }
        $contact = new Contact;
        $contact->firstname = $request->firstname;
        $contact->lastname = $request->lastname;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();
        return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
    }
    public function register(Request $request )
    {
        $checkemail=User::where('email',$request->email)->first();
        $checkmobile=User::where('mobile',$request->mobile)->first();
        $referral_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10); 
        $otp = rand ( 100000 , 999999 );
        if ($request->register_type == "email") {
            if($request->email == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.email_required')],200);
            }
            if($request->name == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.full_name_required')],200);
            }
            if($request->mobile == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.mobile_required')],200);
            }
            if($request->token == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.token_required')],200);
            }
            if(!empty($checkemail)){
                return response()->json(['status'=>0,'message'=>trans('messages.email_exist')],200);
            }
            if(!empty($checkmobile)){
                return response()->json(['status'=>0,'message'=>trans('messages.mobile_exist')],200);
            }
            if ($request->login_type == "google" OR $request->login_type == "facebook") {
                $password = "";
            } else {
                $password = Hash::make($request->password);
            }
            $checkreferral=User::select('id','name','referral_code','wallet','email','token')->where('referral_code',$request['referral_code'])->first();
            if (@$checkreferral->referral_code == $request['referral_code']) {

                if(\App\SystemAddons::where('unique_identifier', 'otp')->first() != null && \App\SystemAddons::where('unique_identifier', 'otp')->first()->activated)
                {
                    $verification = sms_helper::verificationsms($request->mobile,$otp);
                }
                else
                {
                    $verification = helper::verificationemail($request->email,$otp);
                }
                if($verification == 1){
                    $user = new User;
                    $user->name = $request->name;
                    $user->mobile = $request->mobile;
                    $user->email = $request->email;
                    $user->profile_image = 'unknown.png';
                    $user->password = $password;
                    $user->token   = $request->token;
                    $user->login_type = $request->login_type;
                    $user->google_id = $request->google_id;
                    $user->facebook_id = $request->facebook_id;
                    $user->referral_code = $referral_code;
                    $user->otp = $otp;
                    $user->type = '2';
                    if ($request->has('referral_code') && $request->referral_code != "" && !empty($checkreferral)) {
                        $user->user_id = $checkreferral->id;
                        $user->referral_amount = helper::appdata()->referral_amount;
                    }
                    $user->save();
                    $update=User::where('email',$request['email'])->update(['otp'=>$otp,'is_verified'=>'2','token'=>$request->token]);
                    $userprofile = $this->getuserprofileobject($user->id);
                    return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$userprofile,'otp'=>$otp],200);
                }else{
                    return response()->json(['status'=>0,'message'=>trans('messages.email_error')],200);
                }
            } else {
                return response()->json(['status'=>0,'message'=>trans('messages.invalid_referral_code')],200);
            }
        }
        if ($request->login_type == "google") {
            if($request->email == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.email_required')],200);
            }
            if($request->name == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.full_name_required')],200);
            }
            if($request->token == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.token_required')],200);
            }
            if($request->google_id == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.google_id_required')],200);
            }
            $usergoogle=User::where('google_id',$request->google_id)->first();
            if ($usergoogle != "" OR @$usergoogle->email == $request->email AND $request->email != "") {
                if ($usergoogle->mobile == "") {
                    $arrayName = array(
                        'id'=>$usergoogle->id
                    );
                    return response()->json(['status'=>2,'message'=>trans('messages.mobile_required'),'data'=>$arrayName],200);
                } else {
                    if($usergoogle->is_verified == '1') 
                    {
                        if($usergoogle->is_available == '1') 
                        {
                            $update=User::where('email',$usergoogle['email'])->update(['token'=>$request->token]);
                            $userprofile = $this->getuserprofileobject($usergoogle->id);
                            return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$userprofile],200);
                        } else {
                            return response()->json(['status'=>0,'message'=>trans('messages.blocked')],200);
                        }
                    } else {
                        if(\App\SystemAddons::where('unique_identifier', 'otp')->first() != null && \App\SystemAddons::where('unique_identifier', 'otp')->first()->activated)
                        {
                            $verification = sms_helper::verificationsms($usergoogle->mobile,$otp);
                        }
                        else
                        {
                            $verification = helper::verificationemail($usergoogle->email,$otp);
                        }
                        $update=User::where('email',$usergoogle['email'])->update(['otp'=>$otp]);
                        return response()->json(['status'=>3,'message'=>trans('messages.unverified'),'email'=>$usergoogle->email,'otp'=>$otp],200);
                    }
                }
            } else {
                if(!empty($checkemail)){
                    return response()->json(['status'=>0,'message'=>trans('messages.email_exist')],200);
                }
                return response()->json(['status'=>2,'message'=>'Successful'],200);
            }
        } elseif ($request->login_type == "facebook") {
            if($request->email == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.email_required')],200);
            }
            if($request->name == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.full_name_required')],200);
            }
            if($request->token == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.token_required')],200);
            }
            if($request->facebook_id == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.facebook_id_required')],200);
            }
            $userfacebook=User::where('users.facebook_id',$request->facebook_id)->first();
            if ($userfacebook != "" OR @$userfacebook->email == $request->email AND $request->email != "") {
                if ($userfacebook->mobile == "") {
                    $arrayName = array(
                        'id'=>$userfacebook->id
                    );
                    return response()->json(['status'=>2,'message'=>trans('messages.mobile_required'),'data'=>$arrayName],200);
                } else {
                    if($userfacebook->is_verified == '1') 
                    {
                        if($userfacebook->is_available == '1') 
                        {
                            $update=User::where('email',$userfacebook['email'])->update(['token'=>$request->token]);
                            $userprofile = $this->getuserprofileobject($userfacebook->id);
                            return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$userprofile],200);
                        } else {
                            return response()->json(['status'=>0,'message'=>trans('messages.blocked')],200);
                        }
                    } else {
                        
                        if(\App\SystemAddons::where('unique_identifier', 'otp')->first() != null && \App\SystemAddons::where('unique_identifier', 'otp')->first()->activated)
                        {
                            $verification = sms_helper::verificationsms($userfacebook->mobile,$otp);
                        }
                        else
                        {
                            $verification = helper::verificationemail($userfacebook->email,$otp);
                        }
                       
                        $update=User::where('email',$userfacebook['email'])->update(['otp'=>$otp]);
                        return response()->json(['status'=>3,'message'=>trans('messages.unverified'),'email'=>$userfacebook->email,'otp'=>$otp],200);
                    }
                }
            } else {
                if(!empty($checkemail)){
                    return response()->json(['status'=>0,'message'=>trans('messages.email_exist')],200);
                }
                return response()->json(['status'=>2,'message'=>trans('messages.success')],200);
            }
        }
    }
    public function getuserprofileobject($id)
    {
        // NOTE ::- This function is used at multiple places in this controller and also in front->HomeController
        $arr = array(
            'id'=>"",
            'name'=>"",
            'mobile'=>"",
            'email'=>"",
            'login_type'=>"",
            'wallet'=>"",
            'is_notification'=>"",
            'is_mail'=>"",
            'referral_code'=>"",
            'profile_image'=>""
        );
        $checkuser = User::where('id',$id)->first();
        if(!empty($checkuser)){   
            $arr = array(
                'id'=>$checkuser->id,
                'name'=>$checkuser->name,
                'mobile'=>$checkuser->mobile,
                'email'=>$checkuser->email,
                'login_type'=>$checkuser->login_type,
                'wallet'=>$checkuser->wallet,
                'is_notification'=>$checkuser->is_notification == "" ? "" : "$checkuser->is_notification",
                'is_mail'=>$checkuser->is_mail == "" ? "" : "$checkuser->is_mail",
                'referral_code'=>$checkuser->referral_code == "" ? "" : $checkuser->referral_code,
                'profile_image'=>Helper::image_path($checkuser->profile_image)
            );
        }
        return $arr;
    }
}
