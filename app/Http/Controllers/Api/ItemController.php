<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Cart;
use App\Models\User;
use App\Models\Addons;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\DB;
class ItemController extends Controller
{
    public function searchitem(Request $request)
    {
        $user_id = $request->user_id;
        $session_id = $request->session_id;
        if($user_id != "")
        {
                    $itemlist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'),DB::raw('count(order_details.item_id) as item_order_counter'))
                    ->leftJoin('order_details','order_details.item_id','item.id')
                    ->leftJoin('favorite', function($query) use($user_id) {
                        $query->on('favorite.item_id','=','item.id')
                        ->where('favorite.user_id', '=', $user_id);
                    })
                    ->leftJoin('cart', function($query) use($user_id) {
                        $query->on('cart.item_id','=','item.id')
                        ->where('cart.user_id', '=', $user_id);
                    })
                    ->groupBy('item.id','cart.item_id')
                    ->where('item.item_status','1')->where('item.is_deleted',2);
                if($request->has('search') && $request->search != ""){
                    // todayspecial
                    if($request->search == 1){
                        $itemlist = $itemlist->where('item.is_featured',1)->orderByDesc('item.id');
                    }
                    // trendingitems
                    if($request->search == 2){
                        $itemlist = $itemlist->orderByDesc('item_order_counter');
                    }
                    // recommendeditems
                    if($request->search == 3){
                        $itemlist = $itemlist->inRandomOrder();
                    }
                }
                if($request->has('filter') && $request->filter != ""){
                    // veg
                    if($request->filter == 1){
                        $itemlist = $itemlist->where('item.item_type',1);
                    }
                    // nonveg
                    if($request->filter == 2){
                        $itemlist = $itemlist->where('item.item_type',2);
                    }
                }
                $itemlist = $itemlist->get();

                $itemdata = array();
                foreach ($itemlist as $item) {
                    $itemdata[] = $this->getitemlistobject($item,$user_id,$session_id);
                }
                return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$itemdata],200);
        }
        else
        {
                    $itemlist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'),DB::raw('count(order_details.item_id) as item_order_counter'))
                    ->leftJoin('order_details','order_details.item_id','item.id')
                    ->leftJoin('cart', function($query) use($session_id) {
                        $query->on('cart.item_id','=','item.id')
                        ->where('cart.session_id', '=', $session_id);
                    })
                    ->groupBy('item.id','cart.item_id')
                    ->where('item.item_status','1')->where('item.is_deleted',2);
                if($request->has('search') && $request->search != ""){
                    // todayspecial
                    if($request->search == 1){
                        $itemlist = $itemlist->where('item.is_featured',1)->orderByDesc('item.id');
                    }
                    // trendingitems
                    if($request->search == 2){
                        $itemlist = $itemlist->orderByDesc('item_order_counter');
                    }
                    // recommendeditems
                    if($request->search == 3){
                        $itemlist = $itemlist->inRandomOrder();
                    }
                }
                if($request->has('filter') && $request->filter != ""){
                    // veg
                    if($request->filter == 1){
                        $itemlist = $itemlist->where('item.item_type',1);
                    }
                    // nonveg
                    if($request->filter == 2){
                        $itemlist = $itemlist->where('item.item_type',2);
                    }
                }
                $itemlist = $itemlist->get();

                $itemdata = array();
                foreach ($itemlist as $item) {
                    $itemdata[] = $this->getitemlistobject($item,$user_id,$session_id);
                }
                return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$itemdata],200);
        }
        
    }
    public function itemdetails(Request $request)
    {
        $user_id  = $request->user_id;
        $session_id = $request->session_id;
        if($request->item_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.item_required')],200);
        }

        if($user_id != null)
        {
                    $itemdata  = Item::with('category_info','subcategory_info','variation','item_images')->select('item.*',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                    ->leftJoin('favorite', function($query) use($user_id) {
                        $query->on('favorite.item_id','=','item.id')
                        ->where('favorite.user_id', '=', $user_id);
                    })
                    ->leftJoin('cart', function($query) use($user_id) {
                        $query->on('cart.item_id','=','item.id')
                        ->where('cart.user_id', '=', $user_id);
                    })
                    // ->groupBy('item.id','cart.item_id')
                    ->where('item.item_status','1')->where('item.is_deleted','2')
                    ->where('item.id',$request->item_id)
                    ->first();
                
                if(!empty($itemdata)){
                    if($itemdata->is_cart == 1){
                        $cart_qty = Cart::where('item_id',$itemdata->id)->where('user_id',$user_id)->select(DB::raw('SUM(qty) as item_qty'))->first();
                        $item_qty = $cart_qty->item_qty;
                    }else{
                        $item_qty = 0;
                    }
                    $itemdetails = array(
                        "id" => $itemdata->id,
                        "item_name" => $itemdata->item_name,
                        "item_type" => "$itemdata->item_type",
                        "preparation_time" => $itemdata->preparation_time,
                        "price" => "$itemdata->price",
                        "is_favorite" => "$itemdata->is_favorite",
                        'is_cart' => "$itemdata->is_cart",
                        'item_qty' => $item_qty,
                        "tax" => $itemdata->tax,
                        // "image_name" => $itemdata->image,
                        // "image_url" => helper::image_path($itemdata->image),
                        "item_images" => $itemdata['item_images'],
                        "item_description" => $itemdata->item_description == "" ? "" : $itemdata->item_description,
                        "category_info" => $itemdata->category_info,
                        "subcategory_info" => $itemdata->subcategory_info,
                        "has_variation" => "$itemdata->has_variation",
                        "attribute" => $itemdata->attribute == "" ? "" : $itemdata->attribute,
                        "variation" => $itemdata->variation,
                        "addons" => Addons::select('id','name','price')->whereIn('id',explode(',',$itemdata->addons_id))->get()
                    );
                    $itemlist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                        ->leftJoin('favorite', function($query) use($user_id) {
                            $query->on('favorite.item_id','=','item.id')
                            ->where('favorite.user_id', '=', $user_id);
                        })
                        ->leftJoin('cart', function($query) use($user_id) {
                            $query->on('cart.item_id','=','item.id')
                            ->where('cart.user_id', '=', $user_id);
                        })
                        ->groupBy('item.id','cart.item_id')
                        ->where('item.item_status','1')->where('item.is_deleted','2')->where('item.cat_id',$itemdata->cat_id)->where('item.id','!=',$itemdata->id)
                        ->orderByDesc('item.id')->get();
                        $relateditems = array();
                    foreach ($itemlist as $item) {
                        $relateditems[] = $this->getitemlistobject($item,$user_id,$session_id);
                    }
                    return response()->json(['status'=>1,'message'=>trans('messages.success'),"data"=>$itemdetails,"relateditems"=>$relateditems],200);
                }else{
                    return response()->json(['status'=>0,'message'=>trans('messages.invalid_item')],200);
                }
        }
        else
        {

                    $itemdata  = Item::with('category_info','subcategory_info','variation','item_images')->select('item.*',DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                    ->leftJoin('cart', function($query) use($session_id) {
                        $query->on('cart.item_id','=','item.id')
                        ->where('cart.session_id', '=', $session_id);
                    })
                    // ->groupBy('item.id','cart.item_id')
                    ->where('item.item_status','1')->where('item.is_deleted','2')
                    ->where('item.id',$request->item_id)
                    ->first();
                
                if(!empty($itemdata)){
                    if($itemdata->is_cart == 1){
                        $cart_qty = Cart::where('item_id',$itemdata->id)->where('session_id',$session_id)->select(DB::raw('SUM(qty) as item_qty'))->first();
                        $item_qty = $cart_qty->item_qty;
                    }else{
                        $item_qty = 0;
                    }
                    $itemdetails = array(
                        "id" => $itemdata->id,
                        "item_name" => $itemdata->item_name,
                        "item_type" => "$itemdata->item_type",
                        "preparation_time" => $itemdata->preparation_time,
                        "price" => "$itemdata->price",
                        "is_favorite" => "$itemdata->is_favorite",
                        'is_cart' => "$itemdata->is_cart",
                        'item_qty' => $item_qty,
                        "tax" => $itemdata->tax,
                        // "image_name" => $itemdata->image,
                        // "image_url" => helper::image_path($itemdata->image),
                        "item_images" => $itemdata['item_images'],
                        "item_description" => $itemdata->item_description == "" ? "" : $itemdata->item_description,
                        "category_info" => $itemdata->category_info,
                        "subcategory_info" => $itemdata->subcategory_info,
                        "has_variation" => "$itemdata->has_variation",
                        "attribute" => $itemdata->attribute == "" ? "" : $itemdata->attribute,
                        "variation" => $itemdata->variation,
                        "addons" => Addons::select('id','name','price')->whereIn('id',explode(',',$itemdata->addons_id))->get()
                    );
                    $itemlist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                        ->leftJoin('cart', function($query) use($session_id) {
                            $query->on('cart.item_id','=','item.id')
                            ->where('cart.session_id', '=', $session_id);
                        })
                        ->groupBy('item.id','cart.item_id')
                        ->where('item.item_status','1')->where('item.is_deleted','2')->where('item.cat_id',$itemdata->cat_id)->where('item.id','!=',$itemdata->id)
                        ->orderByDesc('item.id')->get();
                        $relateditems = array();
                    foreach ($itemlist as $item) {
                        $relateditems[] = $this->getitemlistobject($item,$user_id,$session_id);
                    }
                    return response()->json(['status'=>1,'message'=>trans('messages.success'),"data"=>$itemdetails,"relateditems"=>$relateditems],200);
                }else{
                    return response()->json(['status'=>0,'message'=>trans('messages.invalid_item')],200);
                }
        }
        
        
    }
    public function category_items(Request $request)
    {
        $user_id  = $request->user_id;
        $session_id  = $request->session_id;
        if($request->cat_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.category_required')],200);
        }
        $checkcategory = Category::where('id',$request->cat_id)->where('is_available',1)->where('is_deleted',2)->first();
        if(!empty($checkcategory)){
            $data = array();

            if($user_id != null)
            {

                        $itemlist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                        ->leftJoin('favorite', function($query) use($user_id) {
                            $query->on('favorite.item_id','=','item.id')
                            ->where('favorite.user_id', '=', $user_id);
                        })
                        ->leftJoin('cart', function($query) use($user_id) {
                            $query->on('cart.item_id','=','item.id')
                            ->where('cart.user_id', '=', $user_id);
                        })
                        ->groupBy('item.id','cart.item_id')
                        ->where('item.item_status','1')->where('item.is_deleted','2')->where('item.cat_id',$request->cat_id)
                        ->orderByDesc('item.id')->get();
                $allitems = array();
                foreach ($itemlist as $item) {
                    $allitems[] = $this->getitemlistobject($item,$user_id,$session_id);
                }
                $data[] = array(
                    "id"=>"",
                    "cat_id"=>"",
                    "subcategory_name"=>trans('labels.all'),
                    "subcategory_items"=>$allitems,
                );
                $subcategories = Subcategory::where('cat_id',$request->cat_id)->where('is_available',1)->where('is_deleted',2)->get();
                foreach($subcategories as $subcat){
                    $itemlist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                        ->leftJoin('favorite', function($query) use($user_id) {
                            $query->on('favorite.item_id','=','item.id')
                            ->where('favorite.user_id', '=', $user_id);
                        })
                        ->leftJoin('cart', function($query) use($user_id) {
                            $query->on('cart.item_id','=','item.id')
                            ->where('cart.user_id', '=', $user_id);
                        })
                        ->groupBy('item.id','cart.item_id')
                        ->where('item.item_status','1')->where('item.is_deleted','2')->where('item.subcat_id',$subcat->id)
                        ->orderByDesc('item.id')->get();
                    $subcatitems = array();
                    foreach ($itemlist as $item) {
                        $subcatitems[] = $this->getitemlistobject($item,$user_id,$session_id);
                    }
                    $data[] = array(
                        "id"=>$subcat->id,
                        "cat_id"=>$subcat->cat_id,
                        "subcategory_name"=>$subcat->subcategory_name,
                        "subcategory_items"=>$subcatitems,
                    );
                }
            }
            else
            {
                        $itemlist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                        ->leftJoin('cart', function($query) use($session_id) {
                            $query->on('cart.item_id','=','item.id')
                            ->where('cart.session_id', '=', $session_id);
                        })
                        ->groupBy('item.id','cart.item_id')
                        ->where('item.item_status','1')->where('item.is_deleted','2')->where('item.cat_id',$request->cat_id)
                        ->orderByDesc('item.id')->get();
                $allitems = array();
                foreach ($itemlist as $item) {
                    $allitems[] = $this->getitemlistobject($item,$user_id,$session_id);
                }
                $data[] = array(
                    "id"=>"",
                    "cat_id"=>"",
                    "subcategory_name"=>trans('labels.all'),
                    "subcategory_items"=>$allitems,
                );
                $subcategories = Subcategory::where('cat_id',$request->cat_id)->where('is_available',1)->where('is_deleted',2)->get();
                foreach($subcategories as $subcat){
                    $itemlist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                        ->leftJoin('cart', function($query) use($session_id) {
                            $query->on('cart.item_id','=','item.id')
                            ->where('cart.session_id', '=', $session_id);
                        })
                        ->groupBy('item.id','cart.item_id')
                        ->where('item.item_status','1')->where('item.is_deleted','2')->where('item.subcat_id',$subcat->id)
                        ->orderByDesc('item.id')->get();
                    $subcatitems = array();
                    foreach ($itemlist as $item) {
                        $subcatitems[] = $this->getitemlistobject($item,$user_id,$session_id);
                    }
                    $data[] = array(
                        "id"=>$subcat->id,
                        "cat_id"=>$subcat->cat_id,
                        "subcategory_name"=>$subcat->subcategory_name,
                        "subcategory_items"=>$subcatitems,
                    );
                }
            }
            return response()->json(["status"=>1,"message"=>trans('messages.success'),'items'=>$data],200);
        }else{
            return response()->json(["status"=>0,"message"=>trans('messages.invalid_category')],200);
        }
    }



    
    public function managefavorite(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
        }
        $checkuser = User::where('id',$request->user_id)->where('is_available',1)->first();
        if(!empty($checkuser))
        {
            if($request->item_id == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.item_required')],200);
            }
            $checkitem = User::find($request->user_id);
            if(!empty($checkitem)){
                $checkfavorite=Favorite::where('user_id',$request->user_id)->where('item_id',$request->item_id)->first();
                if($request->type == "favorite"){
                    if(!empty($checkfavorite)){
                        return response()->json(['status'=>0,'message'=>trans('messages.favorite_available')],200);
                    }else{
                        $favorite = new Favorite;
                        $favorite->user_id =$request->user_id;
                        $favorite->item_id =$request->item_id;
                        $favorite->save();
                        return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
                    }
                }
                if($request->type == "unfavorite"){
                    if(!empty($checkfavorite)){
                        $checkfavorite->delete();
                        return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
                    }else{
                        return response()->json(['status'=>0,'message'=>trans('messages.favorite_not_exist')],200);
                    }
                }
                if($request->type == "" || ($request->type != "favorite" && $request->type != "unfavorite") ){
                    return response()->json(['status'=>0,'message'=>trans('messages.invalid_request')],200);
                }
            }else{
                return response()->json(["status"=>0,"message"=>trans('messages.invalid_item')],200);
            }
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }
    public function favoritelist(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
        }
        $user_id = $request->user_id;
        $itemslist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*','favorite.id as favorite_id',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
            ->join('favorite', function($query) use($user_id) {
                $query->on('favorite.item_id','=','item.id')
                ->where('favorite.user_id', '=', $user_id);
            })
            ->leftJoin('cart', function($query) use($user_id) {
                $query->on('cart.item_id','=','item.id')
                ->where('cart.user_id', '=', $user_id);
            })
            ->groupBy('item.id','cart.item_id')
            ->where('item.item_status','1')
            ->where('item.is_deleted','2')
            ->where('favorite.user_id',$user_id)
            ->orderByDesc('favorite.id')->get();
        $favoritearray = array();
        foreach ($itemslist as $item) {
            $favoritearray[] = $this->getitemlistobject($item,$user_id,$session_id = null);
        }
        return response()->json(['status'=>1,'message'=>trans('messages.success'),"data"=>$favoritearray],200);
    }




    public function getitemlistobject($itemobject,$user_id,$session_id)
    {
        // is_cart = 0 = item is not in cart // is_cart = 1 = item is in cart
        $item_qty = "0";
        if($itemobject->is_cart == 1){
            if($session_id != null)
            {
                $item_qty = Cart::where('item_id',$itemobject->id)->where('session_id',$session_id)->sum('qty');
            }
            if($user_id != null)
            {
                $item_qty = Cart::where('item_id',$itemobject->id)->where('user_id',$user_id)->sum('qty');
            }
            
        }
        return array(
            "id" => $itemobject->id,
            "item_name" => $itemobject->item_name,
            "item_type" => "$itemobject->item_type",
            "preparation_time" => $itemobject->preparation_time,
            "price" => "$itemobject->price",
            "available_qty" => "$itemobject->available_qty",
            "is_favorite" => "$itemobject->is_favorite",
            'is_cart' => "$itemobject->is_cart",
            'item_qty' => $item_qty,
            "tax" => $itemobject->tax,
            // "image_name" => $itemobject->image,
            // "image_url" => helper::image_path($itemobject->image),
            "image_name" => $itemobject['item_image']->image_name,
            "image_url" => $itemobject['item_image']->image_url,
            "item_description" => $itemobject->item_description == "" ? "" : $itemobject->item_description,
            "category_info" => $itemobject->category_info,
            "subcategory_info" => $itemobject->subcategory_info,
            "has_variation" => "$itemobject->has_variation",
            "attribute" => $itemobject->attribute == "" ? "" : $itemobject->attribute,
            "variation" => $itemobject->variation,
            "addons" => Addons::select('id','name','price')->whereIn('id',explode(',',$itemobject->addons_id))->get()
        );
    }
}