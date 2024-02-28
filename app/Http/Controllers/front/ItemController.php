<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Cart;
use App\Models\Addons;
use App\Helpers\helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
class ItemController extends Controller
{
    public function showitem(Request $request)
    {
        $iteminfo = Item::with(['variation','subcategory_info','category_info','item_image'])->where('item.slug','=',$request->slug)->where('item.item_status','1')->where('item.is_deleted','2')->first();
        $itemdata = array(
            "id"=>$iteminfo->id,
            "slug"=>$iteminfo->slug,
            "item_name"=>$iteminfo->item_name,
            "item_type"=>$iteminfo->item_type,
            "item_type_image"=>$iteminfo->item_type == 1 ? helper::image_path("veg.svg") : helper::image_path("nonveg.svg"),
            "preparation_time"=>$iteminfo->preparation_time,
            "price"=>$iteminfo->price,
            "is_featured"=>$iteminfo->is_featured,
            "tax"=>$iteminfo->tax,
            "image_name"=>$iteminfo['item_image']->image_name,
            "item_description"=>$iteminfo->item_description,
            "category_info"=>$iteminfo->category_info,
            "subcategory_info"=>$iteminfo->subcategory_info,
            "has_variation"=>$iteminfo->has_variation,
            "attribute"=>ucfirst($iteminfo->attribute),
            "variation"=>$iteminfo->variation,
            "addons"=>Addons::select('id','name','price')->whereIn('id',explode(',',$iteminfo->addons_id))->get()
        );
        return response()->json(['status'=>1,'message'=>trans('messages.success'), 'itemdata'=>$itemdata], 200);
    }
    public function itemdetails(Request $request)
    {
        $user_id = @Auth::user()->id;
        $session_id = Session::getId();

        if($user_id != null)
        {
                $getitemdata = Item::with('category_info','subcategory_info','variation','item_images')->select('item.*',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('favorite', function($query) use($user_id) {
                    $query->on('favorite.item_id','=','item.id')
                    ->where('favorite.user_id', '=', $user_id);
                })
                ->leftJoin('cart', function($query) use($user_id) {
                    $query->on('cart.item_id','=','item.id')
                    ->where('cart.user_id', '=', $user_id);
                })
                ->groupBy('item.id','cart.item_id')
                ->where('item.slug','=',$request->slug)
                ->where('item.item_status','1')->where('item.is_deleted','2')
                ->first();
            $getitemdata['addons'] = Addons::whereIn('id',explode(',',@$getitemdata->addons_id))->where('is_available',1)->where('is_deleted',2)->get();
            $getrelateditems = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('favorite', function($query) use($user_id) {
                    $query->on('favorite.item_id','=','item.id')
                    ->where('favorite.user_id', '=', $user_id);
                })
                ->leftJoin('cart', function($query) use($user_id) {
                    $query->on('cart.item_id','=','item.id')
                    ->where('cart.user_id', '=', $user_id);
                })
                ->groupBy('item.id','cart.item_id')
                ->orderByDesc('item.id')
                ->where('item.id','!=',@$getitemdata->id)
                ->where('item.cat_id','=',@$getitemdata->cat_id)
                ->where('item.item_status','1')->where('item.is_deleted','2')
                ->take(4)->get();

        }
        else
        {

                $getitemdata = Item::with('category_info','subcategory_info','variation','item_images')->select('item.*',DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('cart', function($query) use($session_id) {
                    $query->on('cart.item_id','=','item.id')
                    ->where('cart.session_id', '=', $session_id);
                })
                ->groupBy('item.id','cart.item_id')
                ->where('item.slug','=',$request->slug)
                ->where('item.item_status','1')->where('item.is_deleted','2')
                ->first();
            $getitemdata['addons'] = Addons::whereIn('id',explode(',',@$getitemdata->addons_id))->where('is_available',1)->where('is_deleted',2)->get();
            $getrelateditems = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('cart', function($query) use($session_id) {
                    $query->on('cart.item_id','=','item.id')
                    ->where('cart.session_id', '=', $session_id);
                })
                ->groupBy('item.id','cart.item_id')
                ->orderByDesc('item.id')
                ->where('item.id','!=',@$getitemdata->id)
                ->where('item.cat_id','=',@$getitemdata->cat_id)
                ->where('item.item_status','1')->where('item.is_deleted','2')
                ->take(4)->get();
        }
        
        return view('web.productdetails',compact('getitemdata','getrelateditems'));
    }
    public function search(Request $request)
    {
        $user_id = @Auth::user()->id;
        $session_id = Session::getId();

        if($user_id != null)
        {
            $getsearchitems = array();
            if($request->has('itemname') && $request->itemname != ""){
                $getsearchitems = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
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
                    ->where('item.item_name','like', '%' . $request->itemname . '%')
                    ->where('item.item_status','1')->where('item.is_deleted','2')
                    ->orderByDesc('item.id')->paginate(16);
            }    
        }
        else
        {
            $getsearchitems = array();
            if($request->has('itemname') && $request->itemname != ""){
                $getsearchitems = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                    ->leftJoin('order_details','order_details.item_id','item.id')
                    ->leftJoin('cart', function($query) use($session_id) {
                        $query->on('cart.item_id','=','item.id')
                        ->where('cart.session_id', '=', $session_id);
                    })
                    ->groupBy('order_details.item_id','item.id','cart.item_id')
                    ->where('item.item_name','like', '%' . $request->itemname . '%')
                    ->where('item.item_status','1')->where('item.is_deleted','2')
                    ->orderByDesc('item.id')->paginate(16);
            }
           
        }
      
        return view('web.search',compact('getsearchitems'));
    }
    public function viewall(Request $request)
    {
        $user_id = @Auth::user()->id;
        $session_id = Session::getId();
        $getsearchitems = array();

        if($user_id != null)
        {
                if($request->has('type') && $request->type != "" && in_array($request->type,array('todayspecial','topitems','recommended'))){
                    $getsearchitems = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'),DB::raw('count(order_details.item_id) as item_order_counter'))
                        ->leftJoin('order_details','order_details.item_id','item.id')
                        ->leftJoin('favorite', function($query) use($user_id) {
                            $query->on('favorite.item_id','=','item.id')
                            ->where('favorite.user_id', '=', $user_id);
                        })
                        ->leftJoin('cart', function($query) use($user_id) {
                            $query->on('cart.item_id','=','item.id')
                            ->where('cart.user_id', '=', $user_id);
                        })
                        ->groupBy('item.id','cart.item_id')->where('item.item_status','1')->where('item.is_deleted','2');
                    if($request->has('type') && $request->type != ""){
                        if($request->type == "todayspecial"){
                            $getsearchitems = $getsearchitems->where('item.is_featured','1')->orderByDesc('item.id');
                        }
                        if($request->type == "topitems"){
                            $getsearchitems = $getsearchitems->orderByDesc('item_order_counter');
                        }
                        if($request->type == "recommended"){
                            $getsearchitems = $getsearchitems->inRandomOrder();
                        }
                    }
                    if($request->has('filter') && $request->filter != ""){
                        if($request->filter == "veg"){
                            $getsearchitems = $getsearchitems->where('item.item_type',1);
                        }
                        if($request->filter == "nonveg"){
                            $getsearchitems = $getsearchitems->where('item.item_type',2);
                        }
                    }
                    $getsearchitems = $getsearchitems->paginate(16);
                }
        }
        else
        {
                if($request->has('type') && $request->type != "" && in_array($request->type,array('todayspecial','topitems','recommended'))){
                    $getsearchitems = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'),DB::raw('count(order_details.item_id) as item_order_counter'))
                        ->leftJoin('order_details','order_details.item_id','item.id')
                        ->leftJoin('cart', function($query) use($session_id) {
                            $query->on('cart.item_id','=','item.id')
                            ->where('cart.session_id', '=', $session_id);
                        })
                        ->groupBy('item.id','cart.item_id')->where('item.item_status','1')->where('item.is_deleted','2');
                    if($request->has('type') && $request->type != ""){
                        if($request->type == "todayspecial"){
                            $getsearchitems = $getsearchitems->where('item.is_featured','1')->orderByDesc('item.id');
                        }
                        if($request->type == "topitems"){
                            $getsearchitems = $getsearchitems->orderByDesc('item_order_counter');
                        }
                        if($request->type == "recommended"){
                            $getsearchitems = $getsearchitems->inRandomOrder();
                        }
                    }
                    if($request->has('filter') && $request->filter != ""){
                        if($request->filter == "veg"){
                            $getsearchitems = $getsearchitems->where('item.item_type',1);
                        }
                        if($request->filter == "nonveg"){
                            $getsearchitems = $getsearchitems->where('item.item_type',2);
                        }
                    }
                    $getsearchitems = $getsearchitems->paginate(16);
                }
        }
        
        return view('web.viewall',compact('getsearchitems'));
    }
}
