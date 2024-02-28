<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Helpers\helper;
use App\Models\User;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Ratting;
use App\Models\Cart;
use App\Models\About;
use App\Models\Item;
use App\Models\Time;
use App\Models\Bookings;
use DateTime;
class HomeController extends Controller
{
    public function newhome(Request $request )
    {
        $getsettings = About::first();
        $is_login_required = $getsettings->login_required;

        $session_id =  Str::random(12);
        $user_id = $request->user_id;
        $sessionid = $request->session_id;
        $checkuser = User::where('id',$user_id)->where('is_available',1)->first();
        if($user_id != "" && empty($checkuser)){
            return response()->json(['status'=>5,'message'=>trans('messages.invalid_user')],200);
        }
        if (\App\SystemAddons::where('unique_identifier', 'otp')->first() != null && \App\SystemAddons::where('unique_identifier', 'otp')->first()->activated) {
            $checkaddons = 'mobile';
        } else {
            $checkaddons = 'email';
        }
        $bannerlist = Banner::with('item_info','category_info')->where('is_available',1)->get();
        $banners = array();
        $banners['topbanners'] = array();
        $banners['bannersection1'] = array();
        $banners['bannersection2'] = array();
        $banners['bannersection3'] = array();
        foreach($bannerlist as $bannerdata){
            if($bannerdata->section == 1){
                $banners['topbanners'][] = array(
                    "id" => $bannerdata->id,
                    "type" => $bannerdata->type == "" ? "":$bannerdata->type,
                    "item_id" => $bannerdata->item_id,
                    "cat_id" => $bannerdata->cat_id,
                    "image" => Helper::image_path($bannerdata->image),
                    "item_info" => $bannerdata['item_info'],
                    "category_info" => $bannerdata['category_info'],
                );
            }
            if($bannerdata->section == 2){
                $banners['bannersection1'][] = array(
                    "id" => $bannerdata->id,
                    "type" => $bannerdata->type == "" ? "":$bannerdata->type,
                    "item_id" => $bannerdata->item_id,
                    "cat_id" => $bannerdata->cat_id,
                    "image" => Helper::image_path($bannerdata->image),
                    "item_info" => $bannerdata['item_info'],
                    "category_info" => $bannerdata['category_info'],
                );
            }
            if($bannerdata->section == 3){
                $banners['bannersection2'][] = array(
                    "id" => $bannerdata->id,
                    "type" => $bannerdata->type == "" ? "":$bannerdata->type,
                    "item_id" => $bannerdata->item_id,
                    "cat_id" => $bannerdata->cat_id,
                    "image" => Helper::image_path($bannerdata->image),
                    "item_info" => $bannerdata['item_info'],
                    "category_info" => $bannerdata['category_info'],
                );
            }
            if($bannerdata->section == 4){
                $banners['bannersection3'][] = array(
                    "id" => $bannerdata->id,
                    "type" => $bannerdata->type == "" ? "":$bannerdata->type,
                    "item_id" => $bannerdata->item_id,
                    "cat_id" => $bannerdata->cat_id,
                    "image" => Helper::image_path($bannerdata->image),
                    "item_info" => $bannerdata['item_info'],
                    "category_info" => $bannerdata['category_info'],
                );
            }
        }
        $categorydata = Category::select('id','category_name',DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/category/')."/', image) AS image"))->where('is_available','=','1')->where('is_deleted','2')->get();
        $testimonials = Ratting::join('users','users.id','ratting.user_id')
					->select('ratting.id','ratting.ratting','ratting.comment',DB::raw('DATE_FORMAT(ratting.created_at, "%d-%m-%Y") as date'),'ratting.user_id','users.name',
						DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/profile/')."/', users.profile_image) AS profile_image"))
					->orderByDesc('ratting.id')->get()->take(5);

                    
       if($request->user_id != null)
       {
            $featured = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
            ->leftJoin('favorite', function($query) use($user_id) {
                $query->on('favorite.item_id','=','item.id')
                ->where('favorite.user_id', '=', $user_id);
            })
            ->leftJoin('cart', function($query) use($user_id) {
                $query->on('cart.item_id','=','item.id')
                ->where('cart.user_id', '=', $user_id);
            })
            ->groupBy('item.id','cart.item_id')
            ->where('item.item_status','1')->where('item.is_deleted','2')->where('item.is_featured','1')
            ->orderByDesc('item.id')->take(10)->get();


            $recommended = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
            ->leftJoin('favorite', function($query) use($user_id) {
                $query->on('favorite.item_id','=','item.id')
                ->where('favorite.user_id', '=', $user_id);
            })
            ->leftJoin('cart', function($query) use($user_id) {
                $query->on('cart.item_id','=','item.id')
                ->where('cart.user_id', '=', $user_id);
            })
            ->groupBy('item.id','cart.item_id')
            ->where('item.item_status','1')->where('item.is_deleted','2')->inRandomOrder()->take(10)->get();


            $topitemlist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('count(order_details.item_id) as item_order_counter'),DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                    ->leftJoin('order_details','order_details.item_id','item.id')
                    ->leftJoin('favorite', function($query) use($user_id) {
                        $query->on('favorite.item_id','=','item.id')
                        ->where('favorite.user_id', '=', $user_id);
                    })
                    ->leftJoin('cart', function($query) use($user_id) {
                        $query->on('cart.item_id','=','item.id')
                        ->where('cart.user_id', '=', $user_id);
                    })
                    ->groupBy('order_details.item_id','item.id','cart.item_id')
                    ->orderByDesc('item_order_counter')
                    ->where('item.item_status','1')->where('item.is_deleted','2')->take(10)->get();


                    $todayspecial = array();
                    foreach ($featured as $fdata) {
                        $todayspecial[] = (new ItemController)->getitemlistobject($fdata,$user_id,$session_id);
                    }
                    
                    $recommendeditems = array();
                    foreach ($recommended as $rdata) {
                        $recommendeditems[] = (new ItemController)->getitemlistobject($rdata,$user_id,$session_id);
                    }
                    
                    $trendingitems = array();
                    foreach ($topitemlist as $topitem) {
                        $trendingitems[] = (new ItemController)->getitemlistobject($topitem,$user_id,$session_id);
                    }
                    $getprofile = (new UserController)->getuserprofileobject($user_id);
       }
       else
       {
            $featured = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
            ->leftJoin('cart', function($query) use($sessionid) {
                $query->on('cart.item_id','=','item.id')
                ->where('cart.session_id', '=', $sessionid);
            })
            ->groupBy('item.id','cart.item_id')
            ->where('item.item_status','1')->where('item.is_deleted','2')->where('item.is_featured','1')
            ->orderByDesc('item.id')->take(10)->get();

            $recommended = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
            ->leftJoin('cart', function($query) use($sessionid) {
                $query->on('cart.item_id','=','item.id')
                ->where('cart.session_id', '=', $sessionid);
            })
            ->groupBy('item.id','cart.item_id')
            ->where('item.item_status','1')->where('item.is_deleted','2')->inRandomOrder()->take(10)->get();


            $topitemlist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('count(order_details.item_id) as item_order_counter'),DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                    ->leftJoin('order_details','order_details.item_id','item.id')
                    ->leftJoin('cart', function($query) use($sessionid) {
                        $query->on('cart.item_id','=','item.id')
                        ->where('cart.session_id', '=', $sessionid);
                    })
                    ->groupBy('order_details.item_id','item.id','cart.item_id')
                    ->orderByDesc('item_order_counter')
                    ->where('item.item_status','1')->where('item.is_deleted','2')->take(10)->get();


                    $todayspecial = array();
                    foreach ($featured as $fdata) {
                        $todayspecial[] = (new ItemController)->getitemlistobject($fdata,$user_id,$sessionid);
                    }
                    
                    $recommendeditems = array();
                    foreach ($recommended as $rdata) {
                        $recommendeditems[] = (new ItemController)->getitemlistobject($rdata,$user_id,$sessionid);
                    }
                    
                    $trendingitems = array();
                    foreach ($topitemlist as $topitem) {
                        $trendingitems[] = (new ItemController)->getitemlistobject($topitem,$user_id,$sessionid);
                    }
                    $getprofile = [
                        "id" => "",
                        "name" =>  "",
                        "mobile" =>  "",
                        "email" => "",
                        "login_type" =>  "",
                        "wallet" => "",
                        "is_notification" =>  "",
                        "is_mail" => "",
                        "referral_code" => "",
                        "profile_image" => ""
                    ];
       }
       
        $cartdata = [
            'total_count' => '0',
            'sub_total' => '0',
        ];

        
        if($user_id != null)
        {
            $cartdata = Cart::select(DB::raw('COUNT(cart.id) as total_count'),DB::raw('(case when SUM(cart.qty*cart.item_price) is null then 0 else SUM(cart.qty*cart.item_price) end) as sub_total'))->where('cart.user_id',$user_id)->first();
        }
        if($request->session_id != "")
        {
            $cartdata = Cart::select(DB::raw('COUNT(cart.id) as total_count'),DB::raw('(case when SUM(cart.qty*cart.item_price) is null then 0 else SUM(cart.qty*cart.item_price) end) as sub_total'))->where('cart.session_id',$request->session_id)->first();
        }
       

        return response()->json(["status"=>1,"message"=>trans('messages.success'),"session_id"=>$session_id,"is_login_required"=>$is_login_required,"trendingitems"=>$trendingitems,"todayspecial"=>$todayspecial,"recommendeditems"=>$recommendeditems,"checkaddons"=>$checkaddons,"environment"=>env('Environment'),"appdata"=>helper::appdata(),"getprofile"=>$getprofile,"cartdata"=>$cartdata,"banners"=>@$banners,"categories"=>$categorydata,"testimonials"=>$testimonials],200);
    }
    public function isopenclose(Request $request)
    {
        date_default_timezone_set(helper::appdata()->timezone);
        $admin = User::first();
        $date = date('Y/m/d h:i:sa');
        $isopenclose=Time::where('day','=',date('l', strtotime($date)))->first();
        $current_time = DateTime::createFromFormat('H:i a', date("h:i a"));
        $open_time = DateTime::createFromFormat('H:i a', $isopenclose->open_time);
        $close_time = DateTime::createFromFormat('H:i a', $isopenclose->close_time);
        $break_start = DateTime::createFromFormat('H:i a', $isopenclose->break_start);
        $break_end = DateTime::createFromFormat('H:i a', $isopenclose->break_end);
        if ($admin->is_online == 1 && $isopenclose->always_close == "2" &&  ( ($current_time > $open_time && $current_time < $break_start) || ($current_time > $break_end && $current_time < $close_time) )   ) {
            $is_cart_empty = "1";

            if($request->has('user_id') && $request->user_id != "")
            {
                $cartdata = Cart::where('user_id',$request->user_id)->get();
            }
            else
            {
                $cartdata = Cart::where('session_id',$request->session_id)->get();
            }
            
            if(!empty($cartdata)){
                $is_cart_empty = "0";
            }
           return response()->json(['status'=>1,'message'=>trans('messages.restaurant_open'),'is_cart_empty'=>$is_cart_empty],200);
        } else {
           return response()->json(['status'=>0,'message'=>trans('messages.restaurant_closed'),'is_cart_empty'=>''],200);
        }
    }

    public function loginrequired(Request $request )
    {
        $session_id =  Str::random(12);
        $getsettings = About::first();
        $is_login_required = $getsettings->login_required;
        return response()->json(["status"=>1,"message"=>trans('messages.success'),"session_id"=>$session_id,"is_login_required"=>$is_login_required]);
    }
    public function booktable(Request $request)
    {
        if($request->name == ""){
            return response()->json(['status'=>0,'message'=>trans('messages.name_required')],200);    
        }
        if($request->email == ""){
            return response()->json(['status'=>0,'message'=>trans('messages.email_required')],200);    
        }
        if($request->mobile == ""){
            return response()->json(['status'=>0,'message'=>trans('messages.mobile_required')],200);
        }
        if($request->guests == ""){
            return response()->json(['status'=>0,'message'=>trans('messages.guests_required')],200);    
        }
        if($request->date == ""){
            return response()->json(['status'=>0,'message'=>trans('messages.date_required')],200);    
        }
        if($request->time == ""){
            return response()->json(['status'=>0,'message'=>trans('messages.time_required')],200);    
        }
        if($request->reservation_type == ""){
            return response()->json(['status'=>0,'message'=>trans('messages.reservation_type_required')],200);    
        }
        $booking_number = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 10)), 0, 10);
        $booking = new Bookings();
        $booking->booking_number = $booking_number;
        $booking->name = $request->name;
        $booking->email = $request->email;
        $booking->mobile = $request->mobile;
        $booking->guests = $request->guests;
        $booking->date = $request->date;
        $booking->time = $request->time;
        $booking->reservation_type = $request->reservation_type;
        $booking->special_request = $request->special_request;
        $booking->save();
        return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
    }
}