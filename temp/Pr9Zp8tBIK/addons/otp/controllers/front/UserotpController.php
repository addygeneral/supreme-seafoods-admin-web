<?php
namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Models\User;
use App\Models\Transaction;
use App\Models\OTPConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Laravel\Socialite\Facades\Socialite;

class UserotpController extends Controller
{
    public function register(Request $request)
    {
        return view('web.auth.register');
    }
    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|numeric|unique:users,mobile',
            'checkbox' => 'accepted'
        ], [
            'name.required' => trans('messages.name_required'),
            'email.required' => trans('messages.email_required'),
            'email.email' => trans('messages.valid_email'),
            'email.unique' => trans('messages.email_exist'),
            'mobile.required' => trans('messages.mobile_required'),
            'mobile.numeric' => trans('messages.numbers_only'),
            'mobile.unique' => trans('messages.mobile_exist'),
            'checkbox.accepted' => trans('messages.accept_terms'),
        ]);

        $email = "";
        $password = "";
        $login_type = "";
        $google_id = "";
        $facebook_id = "";
        if(session()->has('social_login')){
            if(session()->get('social_login')['google_id'] != ""){
                $login_type = "google";
                $google_id = session()->get('social_login')['google_id'];
                $email = session()->get('social_login')['email'];
            }
            if(session()->get('social_login')['facebook_id'] != ""){
                $login_type = "facebook";
                $facebook_id = session()->get('social_login')['facebook_id'];
                $email = session()->get('social_login')['email'];
            }
        }else{
            $email = $request->email;
            $login_type = "email";
        }

        $otp = rand(100000, 999999);

        $checkreferral = User::select('id', 'name', 'referral_code', 'wallet', 'email', 'token')->where('referral_code', $request->referral_code)->where('is_available',1)->first();
        if ($request->has('referral_code') && $request->referral_code != "") {
            if(empty($checkreferral)){
                return redirect()->back()->with('error', trans('messages.invalid_referral_code'));
            }
        }
        
        $checkmobile = User::where('mobile', '+'.$request->country.''.$request->mobile)->first();
        if(!empty($checkmobile)){
            return redirect()->back()->with('error', trans('messages.mobile_exist'));
        }

        $send_otp = helper::verificationsms('+'.$request->country.''.$request->mobile,$otp);
        if ($send_otp == 1) {
            $user = new User;
            $user->name = $request->name;
            $user->mobile = '+'.$request->country.''.$request->mobile;
            $user->email = $email;
            $user->profile_image = 'unknown.png';
            $user->password = $password;
            $user->login_type = $login_type;
            $user->google_id = $google_id;
            $user->facebook_id = $facebook_id;
            $user->referral_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);
            $user->otp = $otp;
            $user->type = 2;
            $user->is_available = 1;
            $user->is_verified = 2;
            $user->save();

            if ($request->has('referral_code') && $request->referral_code != "" && !empty($checkreferral)) {

                // for referral user
                $checkreferral->wallet += helper::appdata()->referral_amount;
                $checkreferral->save();
                $referral_tr = new Transaction;
                $referral_tr->user_id = $checkreferral->id;
                $referral_tr->amount = helper::appdata()->referral_amount;
                $referral_tr->transaction_type = 7;
                $referral_tr->username = $user->name;
                $referral_tr->save();

                // for new user
                $user->wallet = helper::appdata()->referral_amount;
                $user->save();
                $new_user_tr = new Transaction;
                $new_user_tr->user_id = $user->id;
                $new_user_tr->amount = helper::appdata()->referral_amount;
                $new_user_tr->transaction_type = 7;
                $new_user_tr->username = $checkreferral->name;
                $new_user_tr->save();

                $title = trans('labels.referral_earning');
                $body = 'Your friend "' . $user->name . '" has used your referral code to register with Our Restaurant. You have earned "' . helper::currency_format(helper::appdata()->referral_amount) . '" referral amount in your wallet.';
                helper::push_notification($checkreferral->token, $title, $body, "wallet", "");
                $referralmessage = 'Your friend "' . $user->name . '" has used your referral code to register with Restaurant User. You have earned "' . helper::appdata()->currency . '' . number_format(helper::appdata()->referral_amount, 2) . '" referral amount in your wallet.';
                helper::referral($checkreferral->email, $user->name, $checkreferral->name, $referralmessage);
            }
            session()->forget('social_login');
            session()->put('verification_email','+'.$request->country.''.$request->mobile);
            return redirect(route('verification'))->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function verification(Request $request)
    {
        return view('web.auth.verification');
    }
    public function verifyotp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ], [
            'otp.required' => trans('messages.otp_required'),
        ]);
        $mobile = session()->get('verification_email');
        $checkuser = User::where('mobile',$mobile)->where('type',2)->first();
        if(!empty($checkuser)){

            $is_valid_otp = 2;
            $getconfiguration = OTPConfiguration::where('status',1)->first();
            if ($getconfiguration->name == "msg91") {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.msg91.com/api/v5/otp/verify?authkey=".$getconfiguration->msg_authkey."&mobile=".$mobile."&otp=".$request->otp."",
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
            if($is_valid_otp == 1){
                $checkuser->otp = null;
                $checkuser->is_verified = 1;
                $checkuser->save();
                session()->forget('verification_email');
                session()->forget('social_login');  
                
                Auth::loginUsingId($checkuser->id, true);
                return redirect('/')->with('success', trans('messages.success'));
            }else{
                return redirect()->back()->with('error', trans('messages.invalid_otp'));
            }
        }else{
            return redirect()->back()->with('error', trans('messages.invalid_user'));
        }
    }
    public function resendotp()
    {
        $otp = rand ( 100000 , 999999 );
        $mobile = session()->get('verification_email');
        $checkuser = User::where('mobile',$mobile)->first();
        $send_otp = helper::verificationsms($mobile,$otp);
        if ($send_otp == 1) {
            $checkuser->otp = $otp;
            $checkuser->is_verified = 2;
            $checkuser->save();
            return redirect()->back()->with('success', trans('messages.success'));
        }else{
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function login(Request $request)
    {
        return view('web.auth.login');
    }
    public function checklogin(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
        ], [
            'mobile.required' => trans('messages.mobile_required'),
        ]);
        $checkuser = User::where('mobile','+'.$request->country.''.$request->mobile)->where('type',2)->first();
        if(!empty($checkuser))
        {
            if($checkuser->is_available == 1)
            {
                $otp = rand ( 100000 , 999999 );
                $send_otp = helper::verificationsms($checkuser->mobile,$otp);
                if($send_otp == 1){
                    $checkuser->otp = $otp;
                    $checkuser->save();
                    session()->put('verification_email','+'.$request->country.''.$request->mobile);
                    return redirect(route('verification'))->with('success', trans('messages.success'));
                }else{
                    return redirect()->back()->with('error', trans('messages.wrong'));
                }
            }else{
                return redirect(route('login'))->with('error', trans('messages.blocked'));
            }
        }else{
            return redirect(route('login'))->with('error', trans('messages.invalid_user'));
        }
    }
    public function forgotpassword(Request $request)
    {
        return view('web.auth.forgot_password');
    }
    public function sendpass(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ],[
            'email.required' => trans('messages.email_required'),
            'email.email' => trans('messages.valid_email'),
        ]);
        $checkuser = User::where('email',$request->email)->where('type',2)->where('is_available',1)->first();
        if(!empty($checkuser)){
            $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 8 );
            $pass = Helper::send_pass($checkuser->email, $checkuser->name, $password);
            if($pass == 1){
                $checkuser->password = Hash::make($password);
                $checkuser->save();
                return redirect(route('login'))->with('success', trans('messages.password_sent'));
            }else{
                return redirect()->back()->with('error', trans('messages.wrong'));
            }
        }else{
            return redirect()->back()->with('error', trans('messages.invalid_email'));
        }
    }
    public function getprofile(Request $request)
    {
        return view('web.profile.profile');
    }
    public function editprofile(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ],[
            "name.required"=>trans('messages.name_required'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if($request->hasFile('profile_image')){
                $validator = Validator::make($request->all(),[
                    'profile_image' => 'image|mimes:jpeg,jpg,png',
                ],[
                    "profile_image.image"=>trans('messages.enter_image_file'),
                    "profile_image.mimes"=>trans('messages.valid_image'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    if(Auth::user()->profile_image != "unknown.png" && file_exists('storage/app/public/admin-assets/images/profile/'.Auth::user()->profile_image)){
                        unlink('storage/app/public/admin-assets/images/profile/'.Auth::user()->profile_image);
                    }
                    $file = $request->file("profile_image");
                    $filename = 'profile-'.time().".".$file->getClientOriginalExtension();
                    $file->move('storage/app/public/admin-assets/images/profile', $filename);
                    $checkuser = User::find(Auth::user()->id);
                    $checkuser->profile_image = $filename;
                    $checkuser->save();
                }
            }
            $checkuser = User::find(Auth::user()->id);
            $checkuser->name = $request->name;
            $checkuser->save();
            return redirect()->back()->with('success',trans('messages.success'));
        }
    }
    public function referearn(Request $request)
    {
        return view('web.referearn.referearn');
    }
    public function changepassword(Request $request)
    {
        return view('web.changepassword');
    }
    public function updatepassword(Request $request)
    {
        $validator = Validator::make($request->all(),
        [   'old_password' => 'required',
            'new_password' => 'required|different:old_password',
            'confirm_password' => 'required|same:new_password'],
        [   'old_password.required' => trans('messages.old_password_required'),
            'new_password.required' => trans('messages.new_password_required'),
            'new_password.different' => trans('messages.new_password_diffrent'),
            'confirm_password.required' => trans('messages.confirm_password_required'),
            'confirm_password.same' => trans('messages.confirm_password_same') ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if (Hash::check($request->old_password,Auth::user()->password)){
                $pass = User::find(Auth::user()->id);
                $pass->password = Hash::make($request->new_password);
                $pass->save();
                return redirect()->back()->with("success",trans('messages.success'));
            }else{
                return redirect()->back()->with("error",trans('messages.old_password_invalid'))->withInput();
            }
        }
    }
    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect(route('home'));
    }

    // ----------------------> SOCIAL LOGIN <-------------------------- // 

    // google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
            $googleuserdata = Socialite::driver('google')->user();

            $findgoogleuser = User::where('google_id', $googleuserdata->id)->first();

            $checkuser=User::where('email','=',$googleuserdata->email)->where('login_type','!=','google')->first();
            if (!empty($checkuser)) {
                return redirect(route('login'))->with('error', trans('messages.email_exist'));
            }
            $socialdata = array(
                'name' => $googleuserdata->name,
                'email' => $googleuserdata->email,
                'google_id' => $googleuserdata->id,
                'facebook_id' => "",
            );
            session()->put('social_login',$socialdata);
            if(!empty($findgoogleuser)){
                
                if($findgoogleuser->mobile == ""){
                    return redirect(route('register'));
                }else{
                    session()->forget('social_login');
                    if($findgoogleuser->is_available == '1') {
                        $otp = rand ( 100000 , 999999 );
                        $verification = helper::verificationsms($findgoogleuser->mobile,$otp);
                        if($verification == 1){
                            $findgoogleuser->otp = $otp;
                            $findgoogleuser->is_verified = 2;
                            $findgoogleuser->save();
                            session()->put('verification_email',$findgoogleuser->mobile);
                            return redirect(route('verification'))->with('success',trans('messages.success'));
                        }else{
                            return redirect()->back()->with('error',trans('messages.wrong'));
                        }
                    }else {
                        return redirect()->back()->with('error',trans('messages.blocked'));
                    }
                }
            }else{
                return redirect(route('register'));
            }
        
        } catch (Exception $e) {
            // return redirect()->back()->with('error',$e->getMessage());
            return redirect()->back()->with('error',trans('messages.wrong'));
        }
    }


    // for facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback()
    {
        try {
        
            $facebookuserdata = Socialite::driver('facebook')->user();
            
            $findfacebookuser = User::where('facebook_id', $facebookuserdata->id)->first();

            $checkuser=User::where('email','=',$facebookuserdata->email)->where('login_type','!=','facebook')->first();
            if (!empty($checkuser)) {
                return redirect(route('login'))->with('error', trans('messages.email_exist'));
            }
            $socialdata = array(
                'name' => $facebookuserdata->name,
                'email' => $facebookuserdata->email,
                'google_id' => "",
                'facebook_id' => $facebookuserdata->id,
            );
            session()->put('social_login',$socialdata);
            if($findfacebookuser){
         
                if($findfacebookuser->mobile == ""){
                    return redirect(route('register'));
                }else{
                    session()->forget('social_login');
                    if($findfacebookuser->is_available == '1') {
                        $otp = rand ( 100000 , 999999 );
                        $verification = helper::verificationsms($findfacebookuser->mobile,$otp);
                        if($verification == 1){
                            $findfacebookuser->otp = $otp;
                            $findfacebookuser->is_verified = 2;
                            $findfacebookuser->save();
                            session()->put('verification_email',$findfacebookuser->mobile);
                            return redirect(route('verification'))->with('success',trans('messages.success'));
                        }else{
                            return redirect()->back()->with('error',trans('messages.wrong'));
                        }
                    }else {
                        return redirect()->back()->with('error',trans('messages.blocked'));
                    }
                }
            }else{
                return redirect(route('register'));
            }
        } catch (Exception $e) {
            // return redirect()->back()->with('error',$e->getMessage());
            return redirect()->back()->with('error',trans('messages.wrong'));
        }
    }
}
