<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Item;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Else_;
use Session;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $user_id = @Auth::user()->id;
        $session_id = Session::getId();

        $categorydata = Category::where('slug',$request->category)->where('is_available',1)->where('is_deleted',2)->first();
        $subcategories = Subcategory::where('cat_id',@$categorydata->id)->where('is_available',1)->where('is_deleted',2)->get();
        

        if($user_id != null)
        {
        
        $getitemlist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
            ->leftJoin('favorite', function($query) use($user_id) {
                $query->on('favorite.item_id','=','item.id')
                ->where('favorite.user_id', '=', $user_id);
            })
            ->leftJoin('cart', function($query) use($user_id) {
                $query->on('cart.item_id','=','item.id')
                ->where('cart.user_id', '=', $user_id);
            })
            ->groupBy('item.id','cart.item_id')
            ->where('item.item_status','1')->where('item.is_deleted','2')
            ->where('item.cat_id',@$categorydata->id)
            ->orderBy('item.reorder_id');

        }
        else
        {
            $getitemlist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*',DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
            ->leftJoin('cart', function($query) use($session_id) {
                $query->on('cart.item_id','=','item.id')
                ->where('cart.session_id', '=', $session_id);
            })
            ->groupBy('item.id','cart.item_id')
            ->where('item.item_status','1')->where('item.is_deleted','2')
            ->where('item.cat_id',@$categorydata->id)
            ->orderBy('item.reorder_id');
        }

        if($request->has('subcategory') && $request->subcategory != ""){
            $subcatdata = Subcategory::where('slug',$request->subcategory)->first();
            if(empty($subcatdata)){
                return redirect()->back();
            }
            $getitemlist = $getitemlist->where('item.subcat_id',@$subcatdata->id);
        }
        $getitemlist = $getitemlist->orderByDesc('item.id')->paginate(16);
        return view('web.menu',compact('categorydata','subcategories','getitemlist'));
    }
}