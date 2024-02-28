<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Models\About;
use App\Models\Slider;
use App\Models\Item;
use App\Models\Banner;
use App\Models\Blogs;
use App\Models\Ratting;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user_id = @Auth::user()->id;
        $session_id = Session::getId();
        $sliders = Slider::with('item_info','category_info')->where('is_available',1)->orderByDesc('id')->get();
        $bannerlist = Banner::with('item_info','category_info')->where('is_available',1)->orderByDesc('id')->get();
        $banners = array();
        $banners['topbanners'] = array();
        $banners['bannersection1'] = array();
        $banners['bannersection2'] = array();
        $banners['bannersection3'] = array();
        foreach($bannerlist as $bannerdata){
            if($bannerdata->section == 1){
                $banners['topbanners'][] = array(
                    "id" => $bannerdata->id,
                    "item_id" => $bannerdata->item_id,
                    "cat_id" => $bannerdata->cat_id,
                    "image" => Helper::image_path($bannerdata->image),
                    "item_info" => $bannerdata->item_info,
                    "category_info" => $bannerdata->category_info,
                );
            }
            if($bannerdata->section == 2){
                $banners['bannersection1'][] = array(
                    "id" => $bannerdata->id,
                    "item_id" => $bannerdata->item_id,
                    "cat_id" => $bannerdata->cat_id,
                    "image" => Helper::image_path($bannerdata->image),
                    "item_info" => $bannerdata->item_info,
                    "category_info" => $bannerdata->category_info,
                );
            }
            if($bannerdata->section == 3){
                $banners['bannersection2'][] = array(
                    "id" => $bannerdata->id,
                    "item_id" => $bannerdata->item_id,
                    "cat_id" => $bannerdata->cat_id,
                    "image" => Helper::image_path($bannerdata->image),
                    "item_info" => $bannerdata->item_info,
                    "category_info" => $bannerdata->category_info,
                );
            }
            if($bannerdata->section == 4){
                $banners['bannersection3'][] = array(
                    "id" => $bannerdata->id,
                    "item_id" => $bannerdata->item_id,
                    "cat_id" => $bannerdata->cat_id,
                    "image" => Helper::image_path($bannerdata->image),
                    "item_info" => $bannerdata->item_info,
                    "category_info" => $bannerdata->category_info,
                );
            }
        }
        $getblogs = Blogs::orderBydesc('id')->take('3')->get();
        $testimonials = Ratting::with('user_info')->orderByDesc('ratting.id')->take('5')->get();

        if($user_id != null)
        {
            $todayspecial = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
            ->leftJoin('favorite', function($query) use($user_id) {
                $query->on('favorite.item_id','=','item.id')
                ->where('favorite.user_id', '=', $user_id);
            })
            ->leftJoin('cart', function($query) use($user_id) {
                $query->on('cart.item_id','=','item.id')
                ->where('cart.user_id', '=', $user_id);
            })
            ->groupBy('item.id','cart.item_id')
            ->where('item.is_featured','1')->where('item.item_status','1')->where('item.is_deleted',2)->orderByDesc('item.id')->take(8)->get();
            
            $topitemlist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*','order_details.qty as order_details_qty',DB::raw('count(order_details.item_id) as item_order_counter'),DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
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
            ->where('item.item_status','1')->where('item.is_deleted',2)->take(8)->get();
            
            $recommended = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
            ->leftJoin('favorite', function($query) use($user_id) {
                $query->on('favorite.item_id','=','item.id')
                ->where('favorite.user_id', '=', $user_id);
            })
            ->leftJoin('cart', function($query) use($user_id) {
                $query->on('cart.item_id','=','item.id')
                ->where('cart.user_id', '=', $user_id);
            })
            ->groupBy('item.id','cart.item_id')
            ->inRandomOrder()
            ->where('item.item_status','1')->where('item.is_deleted',2)->take(8)->get();
        }
        else
        {
            $todayspecial = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
            ->leftJoin('cart', function($query) use($session_id) {
                $query->on('cart.item_id','=','item.id')
                ->where('cart.session_id', '=', $session_id);
            })
            ->groupBy('item.id','cart.item_id')
            ->where('item.is_featured','1')->where('item.item_status','1')->where('item.is_deleted',2)->orderByDesc('item.id')->take(8)->get();
        
            $topitemlist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*','order_details.qty as order_details_qty',DB::raw('count(order_details.item_id) as item_order_counter'),DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
            ->leftJoin('order_details','order_details.item_id','item.id')
            ->leftJoin('cart', function($query) use($session_id) {
                $query->on('cart.item_id','=','item.id')
                ->where('cart.session_id', '=', $session_id);
            })
            ->groupBy('order_details.item_id','item.id','cart.item_id')
            ->orderByDesc('item_order_counter')
            ->where('item.item_status','1')->where('item.is_deleted',2)->take(8)->get();
            
            $recommended = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
            ->leftJoin('cart', function($query) use($session_id) {
                $query->on('cart.item_id','=','item.id')
                ->where('cart.session_id', '=', $session_id);
            })
            ->groupBy('item.id','cart.item_id')
            ->inRandomOrder()
            ->where('item.item_status','1')->where('item.is_deleted',2)->take(8)->get();
        }

        $setting = About::first();
        return view('web.home'.$setting->theme.'.index',compact('sliders','banners','todayspecial', 'topitemlist','testimonials', 'getblogs', 'recommended'));
    }
    public function categories(Request $request)
    {
        return view('web.categoryviewall');
    }
    public function menu(Request $request)
    {
        return view('web.menu');
    }
    public function change_dir(Request $request)
    {
        session()->put('direction', $request->dir);
        return redirect()->back();
    }
}