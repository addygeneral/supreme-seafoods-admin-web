<?php
namespace App\Helpers;
use App\Models\About;
use App\Models\Roles;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Zone;
use App\Models\Payment;
use App\Models\OTPConfiguration;
use App\Models\FooterFeatures;
use App\Models\Ratting;
use App\Models\User;
use App\Models\Time;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Twilio\Rest\Client;
use DateTime;
use Session;

class helper
{
    public static function push_notification($token,$title,$body,$type,$order_id)
    {   
        $customdata = array(
            "type" => $type,
            'sub_type'=> "",
            'category_id'=> "",
            'category_name'=> "",
            'item_id'=> "",
            "order_id" => $order_id,
        );

        if($title == ""){
            $title = @helper::appdata()->website_title;
        }
        $msg = array(
            'body' =>$body,
            'title'=>$title,
            'sound'=>1/*Default sound*/
        );
        $fields = array(
            'to'           =>$token,
            'notification' =>$msg,
            'data'=> $customdata
        );
        $headers = array(
            'Authorization: key=' . @helper::appdata()->firebase,
            'Content-Type: application/json'
        );
        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }
    public static function image_path($image)
    {
        $path = url(env('ASSETSPATHURL').'admin-assets/images/no-found');

        if(Str::contains($image, 'noaccess')){
            $path = url(env('ASSETSPATHURL').'admin-assets/images/'.$image);
        }
        if(Str::contains($image, 'category')){
            $path = url(env('ASSETSPATHURL').'admin-assets/images/category/'.$image);
        }
        if(Str::contains($image, 'profile') || Str::contains($image, 'unknown') || Str::contains($image, 'identity') ){
            $path = url(env('ASSETSPATHURL').'admin-assets/images/profile/'.$image);
        }
        if(Str::contains($image, 'item')){
            $path = url(env('ASSETSPATHURL').'admin-assets/images/item/'.$image);
        }
        if(Str::contains($image, 'banner-')){
            $path = url(env('ASSETSPATHURL').'admin-assets/images/banner/'.$image);
        }
        if(Str::contains($image, 'slider')){
            $path = url(env('ASSETSPATHURL').'admin-assets/images/slider/'.$image);
        }
        if(Str::contains($image, 'theme')){
            $path = url(env('ASSETSPATHURL').'admin-assets/images/theme/'.$image);
        }
        if(Str::contains($image, 'mobile_app_bg_image') || Str::contains($image, 'booknow_bg_image') || Str::contains($image, 'reviews_bg_image') || Str::contains($image, 'footer_bg_image') || Str::contains($image, 'auth_bg_image') || Str::contains($image, 'breadcrumb_bg_image') || Str::contains($image, 'authformbgimage') || Str::contains($image, 'payment-') || Str::contains($image, 'app_bottom_image') || Str::contains($image, 'mobile_app_image') || Str::contains($image, 'blog') || Str::contains($image, 'veg') || Str::contains($image, 'gallery') || Str::contains($image, 'tutorial') || Str::contains($image, 'team') || Str::contains($image, 'default') || Str::contains($image, 'about') || Str::contains($image, 'footer') || Str::contains($image, 'logo') || Str::contains($image, 'favicon') || Str::contains($image, 'og_image' )){
            $path = url(env('ASSETSPATHURL').'admin-assets/images/about/'.$image);
        }
        return $path;
    }

    public static function web_image_path($image)
    {
        $path = url(env('ASSETSPATHURL').'admin-assets/images/not-found');
        if(Str::contains($image, 'refer') || Str::contains($image, 'nodata') || Str::contains($image, 'nexticon') || Str::contains($image, 'playstore') || Str::contains($image, 'appstore') || Str::contains($image, 'bg1') || Str::contains($image, 'bg2') || Str::contains($image, 'breadcrumb_bg') || Str::contains($image, 'section_bg') || Str::contains($image, 'footer_bg') || Str::contains($image, 'facebook') || Str::contains($image, 'google') || Str::contains($image, 'delivery') || Str::contains($image, 'takeaway') || Str::contains($image, 'cod')|| Str::contains($image, 'wallet') || Str::contains($image, 'razorpay') || Str::contains($image, 'paystack') || Str::contains($image, 'stripe')  || Str::contains($image, 'flutterwave') ){
            $path = url(env('ASSETSPATHURL').'web-assets/images/'.$image);
        }
        return $path;
    }
    public static function verificationemail($email, $otp){
        $data=['title'=>trans('messages.email_code'),'email'=>$email,'otp'=>$otp,'logo'=>Helper::image_path(@Helper::appdata()->logo)];
        try {
            Mail::send('Email.emailverification',$data,function($message)use($data){
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_pass($email, $name, $password){
        $data = ['title'=>trans('labels.new_password'),'email'=>$email,'name'=>$name,'password'=>$password,'logo'=>Helper::image_path(@Helper::appdata()->logo)];
        try {
            Mail::send('Email.email',$data,function($message)use($data){
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function referral($email,$name,$toname,$referralmessage){
        $data = ['title'=>trans('labels.referral_earning'),'email'=>$email,'name'=>$name,'toname'=>$toname,'logo'=>Helper::image_path(@Helper::appdata()->logo),'referralmessage'=>$referralmessage];
        try {
            Mail::send('Email.referral',$data,function($message)use($data){
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function create_order_invoice($user_email,$user_name,$order_number,$orderdata,$itemdata)
    {
        $data = ['title'=>trans('labels.order_placed'),'email'=>$user_email,'name'=>$user_name,'order_number'=>$order_number,'orderdata'=>$orderdata,'itemdata'=>$itemdata,'logo'=>Helper::image_path(@Helper::appdata()->logo)];
        try {
            Mail::send('Email.emailinvoice', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function order_status_email($email,$name,$title,$message_text)
    {
        $data = ['email'=>$email,'name'=>$name,'title'=>$title,'message_text'=>$message_text,'logo'=>Helper::image_path(@Helper::appdata()->logo)];
        try {
            Mail::send('Email.orderemail', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function get_roles(){
        $data = Roles::select('modules')->where('id',Auth::user()->role_id)->first();
        return @$data->modules;
    }
    public static function get_user_cart(){
        $count = 0;
        if(Auth::user())
        {
            $count = Cart::where('user_id',Auth::user()->id)->count();
        }
        else
        {
            $count = Cart::where('session_id',Session::getId())->count();
        }

        return $count;
    }
    public static function currency_format($price){
        $price = floatval($price);
        if (@helper::appdata()->currency_position == "1") {
            return @helper::appdata()->currency.number_format($price, 2);
        }
        if (@helper::appdata()->currency_position == "2") {
            return number_format($price, 2).@helper::appdata()->currency;
        }
    }
    public static function appdata(){
        $data = About::select('*',\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/about')."/', app_bottom_image) AS app_bottom_image_url"),\DB::raw('(case when app_bottom_image is null then 0 else 1 end) as is_app_bottom_image'))->first();
        return $data;
    }
    public static function stripe_data()
    {
        return Payment::select('environment','public_key','secret_key','currency')->where('id','=',4)->where('is_available',1)->first();
    }
    public static function check_alert()
    {
        if(@Helper::appdata()->max_order_qty != "" && @Helper::appdata()->min_order_amount != "" && @Helper::appdata()->max_order_amount != "" && @Helper::appdata()->address != "" && @Helper::appdata()->firebase != "" && @Helper::appdata()->map != "" ){
            return 1;
        }else{
            return 0;
        }
    }
    public static function check_restaurant_closed()
    {
        if(@helper::appdata()->timezone != ""){
            date_default_timezone_set(helper::appdata()->timezone);
        }
        $checkstatus = User::find(Auth::user()->id);

        $isopenclose = Time::where('day','=',date('l', strtotime(date('Y/m/d h:i:sa'))))->first();
        $current_time = DateTime::createFromFormat('H:i a', date("h:i a"));
        $open_time = DateTime::createFromFormat('H:i a', $isopenclose->open_time);
        $close_time = DateTime::createFromFormat('H:i a', $isopenclose->close_time);
        $break_start = DateTime::createFromFormat('H:i a', $isopenclose->break_start);
        $break_end = DateTime::createFromFormat('H:i a', $isopenclose->break_end);
        if ($isopenclose->always_close == "2" && ( ($current_time > $open_time && $current_time < $break_start) || ($current_time > $break_end && $current_time < $close_time) )   ) {
            $status = $checkstatus->is_online;
        } else {
            $checkstatus->is_online = 2;
            $checkstatus->save();
            $status = 2;
        }
        return $status;
    }
    public static function date_format($date){
        return date("j F Y",strtotime($date));
    }
    public static function date_time_format($date){
        return date("j F Y, g:i a",strtotime($date));
    }
    public static function number_format($number){
        // $number = (float)$number;
        // return number_format($number, 2, '.', '');
        return $number;
    }



    public static function checkzone($lat,$lang)
    {
       
        // used at add-update-address(Web+app) and before place-order(Web+app) time...
        if (env('Environment') == 'sendbox') {
            return true;
        }else{
            $zonedatas = Zone::select('id','name','coordinates','delivery_charge')->get();
            
            if(empty($zonedatas)){
                return false;
            }else{
                
                foreach($zonedatas as $zonedata)
                {   
                        $coordinates = str_replace(['(',')',' '],'',explode('),',$zonedata->coordinates));

                        foreach($coordinates as $value){
                            $arr = explode(',',$value);
                            $vertices_x[] = $arr[0]; // create array of all latitude points from the polygon OR your area
                            $vertices_y[] = $arr[1]; // create array of all longitude points from the polygon OR your area
                        }
                        $points_polygon = count($vertices_x) - 1;  // number vertices - zero-based array
                        $longitude_x = $lat;  // x-coordinate of the point to test
                        $latitude_y = $lang;    // y-coordinate of the point to test
                        $check= self::is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y); 
                       
                        if ($check == 1)
                        {
                            $delivery_charge = $zonedata->delivery_charge;
                            return $delivery_charge;
                        }
                       
                }
                
            }
        }
    }

    public static function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y){
        $i = $j = $c = 0;
        for ($i = 0, $j = $points_polygon-1 ; $i < $points_polygon; $j = $i++) {
            if ( (($vertices_y[$i] > $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
            ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) ) 
                $c = !$c;
        }
        return $c;
    }
        
    
    public static function check_review_exist($user_id){
        $data = Ratting::where('user_id',$user_id)->first();
        if (!empty($data)) {
            return 1;
        }
        return 0;
    }

    public static function get_theme()
    {
        $setting = About::first();
        return $setting->theme;
    }

    
    
    // front
    public static function footer_features()
    {
        return FooterFeatures::select('id','icon','title','description')->orderByDesc('id')->get();
    }
    public static function get_categories()
    {
        return Category::select('id','category_name','slug','image')->where('is_available','=','1')->where('is_deleted','2')->orderBy('reorder_id')->get();
    }
    public static function get_item_cart($item_id)
    {
        if(Auth::user())
        {
            return Cart::where('item_id',$item_id)->where('user_id',Auth::user()->id)->sum('qty');
        }
        else
        {
            return Cart::where('item_id',$item_id)->where('session_id',Session::getId())->sum('qty');
        }       
    }
}
