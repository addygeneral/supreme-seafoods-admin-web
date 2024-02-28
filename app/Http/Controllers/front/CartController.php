<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use App\Models\About;
use App\Models\Promocode;
use App\Helpers\helper;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Auth;
use Session;
class CartController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user())
        {
        $getcartlist = Cart::where('user_id',Auth::user()->id)->orderByDesc('id')->get();
        }
        else
        {
        $getcartlist = Cart::where('session_id',Session::getId())->orderByDesc('id')->get();
        }

        $getsettings = About::first();

        $getpromocodelist=Promocode::select('offer_name','offer_code','offer_type','offer_amount','min_amount','usage_type','start_date','expire_date','description')->where('is_available',1)->get();
        return view('web.cart.cart',compact('getcartlist','getpromocodelist','getsettings'));
    }
    public function addtocart(Request $request)
    {
        try {
            $itemdata = Item::where('slug',$request->slug)->first();
            $cart = new Cart();
            if(Auth::user())
            {
                $cart->user_id = Auth::user()->id;
                $cart->session_id = "";
            }
            else
            {
                $cart->user_id = "";
                $cart->session_id = Session::getId();
            }
            
            
            $cart->item_id = $itemdata->id;
            $cart->item_name = $request->item_name;
            $cart->item_type = $request->item_type;
            $cart->item_image = $request->image_name;
            $cart->tax = helper::number_format($request->tax);
            $cart->item_price = helper::number_format($request->item_price);
            $cart->variation_id = $request->variation_id == "" ? "" : $request->variation_id;
            $cart->variation = $request->variation_name == "" ? "" : $request->variation_name;
            $cart->addons_id = $request->addons_id == "" ? "" : $request->addons_id;
            $cart->addons_name = $request->addons_name == "" ? "" : $request->addons_name;
            $cart->addons_price = $request->addons_price == "" ? "" : $request->addons_price;
            $cart->addons_total_price = helper::number_format($request->addons_price=="" ? 0 : array_sum(explode(',',$request->addons_price)));
            $cart->qty = 1;
            $cart->save();

            if(Auth::user())
            {
                $total_count = Cart::where('user_id',Auth::user()->id)->count();
            }
            else
            {
                $oldsessionid= Session::getId();
                Session::put('oldsessionid', $oldsessionid);
                $total_count = Cart::where('session_id',Session::getId())->count();
            }
           
            return response()->json(['status'=>1,'message'=>trans('messages.success'), 'data'=>$total_count,'total_item_count'=>helper::get_item_cart($itemdata->id)], 200);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['status'=>0,'message'=>trans('messages.wrong')], 200);
        }
    }
    public function deletecartitem(Request $request)
    {
        $checkcart = Cart::find($request->id);
        if (!empty($checkcart)) {
            $checkcart->delete();
            session()->forget('discount_data');
            return 1;
        } else {
            return 0;
        }
    }
    public function qtyupdate(Request $request)
    {
        $checkcart = Cart::find($request->id);
        if(Auth::user())
        {
            $total_count = Cart::where('user_id',Auth::user()->id)->sum('qty');
        }
        else
        {
            $total_count = Cart::where('session_id',Session::getId())->sum('qty');
        }
      
        if(!empty($checkcart)){
            try {
                if($checkcart->qty == 1 && $request->type == "minus"){
                    $checkcart->delete();
                    session()->forget('discount_data');
                }else{
                    if($request->type == "plus"){
                        if($total_count < helper::appdata()->max_order_qty){
                            $checkcart->qty += 1;
                        }else{
                            $msg = trans('messages.order_qty_less_then').' : '.helper::appdata()->max_order_qty;
                            return response()->json(['status'=>2,'message'=>$msg],200);
                        }
                    }
                    if($request->type == "minus"){
                        $checkcart->qty -= 1;
                        session()->forget('discount_data');
                    }
                    $checkcart->save();
                }
                return response()->json(['status'=>1,'message'=>trans('messages.success')]);
            } catch (\Throwable $th) {
                return response()->json(['status'=>0,'message'=>trans('messages.wrong')]);
            }
            return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_cart')],200);
        }
    }
}
