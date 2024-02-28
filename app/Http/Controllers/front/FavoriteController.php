<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Item;
use App\Helpers\helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use URL;
class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $user_id = @Auth::user()->id;
        $getfavoritelist = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*','favorite.id as favorite_id',DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),DB::raw('(case when item.price is null then 0 else item.price end) as item_price'),DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
        ->join('favorite', function($query) use($user_id) {
            $query->on('favorite.item_id','=','item.id')
            ->where('favorite.user_id', '=', $user_id);
        })
        ->leftJoin('cart', function($query) use($user_id) {
            $query->on('cart.item_id','=','item.id')
            ->where('cart.user_id', '=', $user_id);
        })
        ->groupBy('item.id','cart.item_id','favorite.item_id')
        ->where('item.item_status','1')
        ->where('item.is_deleted','2')
        ->where('favorite.user_id',$user_id)
        ->orderByDesc('favorite.id')->paginate(10);
        return view('web.favoritelist',compact('getfavoritelist'));
    }
    public function managefavorite(Request $request)
    {
        $baseurl = url('/');
       
        $data = '';
        $checkfavorite = Favorite::where('user_id',Auth::user()->id)->where('item_id',$request->slug)->first();
        try {
            if($request->type == 1){
                $favorite = new Favorite();
                $favorite->user_id = Auth::user()->id;
                $favorite->item_id = $request->slug;
                $favorite->save();

                $data = '<a class="heart-icon btn btn-wishlist" href="javascript:void(0)" onclick="managefavorite('.$request->slug.',0,'.chr(0x27).$request->favurl.chr(0x27).','.chr(0x27).$request->url.chr(0x27).')" title="'.trans('labels.remove_wishlist').'"> <i class="fa-solid fa-bookmark fs-5"></i> </a>';

                if($request->url == $baseurl)
                {
                    if(helper::get_theme() == 1)
                    {
                        $data = '<a class="heart-icon btn btn-wishlist" href="javascript:void(0)" onclick="managefavorite('.$request->slug.',0,'.chr(0x27).$request->favurl.chr(0x27).','.chr(0x27).$request->url.chr(0x27).')" title="'.trans('labels.remove_wishlist').'"> <i class="fa-solid fa-bookmark fs-5"></i> </a>';
                    }
                    else if(helper::get_theme() == 2)
                    {
                        $data = '<a class="heart-icon btn btn-sm text-dark" href="javascript:void(0)" onclick="managefavorite('.$request->slug.',0,'.chr(0x27).$request->favurl.chr(0x27).','.chr(0x27).$request->url.chr(0x27).')" title="'.trans('labels.remove_wishlist').'"> <i class="fa-solid fa-bookmark fs-6"></i> </a>';
                    }
                    else
                    {
                        $data = '<a class="heart-icon btn btn-sm text-dark p-0" href="javascript:void(0)" onclick="managefavorite('.$request->slug.',0,'.chr(0x27).$request->favurl.chr(0x27).','.chr(0x27).$request->url.chr(0x27).')" title="'.trans('labels.remove_wishlist').'"> <i class="fa-solid fa-bookmark fs-6"></i> </a>';
                    }
                }
                
               
            }
            if($request->type == 0){
                $checkfavorite->delete();

                $data = '<a class="heart-icon btn btn-wishlist" href="javascript:void(0)" onclick="managefavorite('.$request->slug.',1,'.chr(0x27).$request->favurl.chr(0x27).','.chr(0x27).$request->url.chr(0x27).')" title="'.trans('labels.add_wishlist').'"> <i class="fa-regular fa-bookmark fs-5"></i> </a>';
                if($request->url == $baseurl)
                {
                    if(helper::get_theme() == 1)
                    {
                        $data = '<a class="heart-icon btn btn-wishlist" href="javascript:void(0)" onclick="managefavorite('.$request->slug.',1,'.chr(0x27).$request->favurl.chr(0x27).','.chr(0x27).$request->url.chr(0x27).')" title="'.trans('labels.add_wishlist').'"> <i class="fa-regular fa-bookmark fs-5"></i> </a>';
                    }
                    else if(helper::get_theme() == 2)
                    {
                        $data = '<a class="heart-icon btn btn-sm text-dark" href="javascript:void(0)" onclick="managefavorite('.$request->slug.',1,'.chr(0x27).$request->favurl.chr(0x27).','.chr(0x27).$request->url.chr(0x27).')" title="'.trans('labels.add_wishlist').'"> <i class="fa-regular fa-bookmark fs-6"></i> </a>';
                    }
                    else
                    {
                        $data = '<a class="heart-icon btn btn-sm text-dark p-0" href="javascript:void(0)" onclick="managefavorite('.$request->slug.',1,'.chr(0x27).$request->favurl.chr(0x27).','.chr(0x27).$request->url.chr(0x27).')" title="'.trans('labels.add_wishlist').'"> <i class="fa-regular fa-bookmark fs-6"></i> </a>';
                    }
                }

            }
            return response()->json(['status'=>1,'message'=>trans('messages.success'),"data"=>$data],200);
        } catch (\Throwable $th) {
            return response()->json(['status'=>0,'message'=>trans('messages.wrong'),"data"=>$data],200);
        }
    }
}
