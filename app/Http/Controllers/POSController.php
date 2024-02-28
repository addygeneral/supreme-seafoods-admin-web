<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Models\Item;
use App\Models\Addons;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class PosController extends Controller
{
    public function index(Request $request)
    {
        $getitem = Item::with('category_info','subcategory_info','variation','item_image')->join('categories','item.cat_id','=','categories.id')->select('item.*')->where('item.item_status','1')->where('item.is_deleted','2')->where('categories.is_available','1');
        if($request->has('search') && $request->search != "" ){
            $search = $request->search;
            $getitem = $getitem->where(function ($query) use($search){
                        $query->where('item.item_name', 'like','%'.$search.'%');
                    });
        }
        if($request->has('option') && $request->option != "" ){
            $option = $request->option == "veg" ? 1 : 2;
            $getitem = $getitem->where('item_type',$option);
        }
        $getitem = $getitem->orderByDesc('id')->paginate(12);
        return view('admin.pos.index', compact('getitem'));
    }
    public function addtocart(Request $request)
    {
        try {
            //code...
            $cart = session()->get('cartdata');
            $cart == "" ? $count = 1 : $count = count($cart)+1;
            $cart[$count] = [
                "item_id"=>$request->item_id,
                "item_name"=>$request->item_name,
                "item_type"=>$request->item_type,
                "image_name"=>$request->image_name,
                "tax"=>$request->tax,
                "item_price"=>$request->item_price,
                "addons_id"=>$request->addons_id,
                "addons_name"=>$request->addons_name,
                "addons_price"=>$request->addons_price,
                "addons_total_price"=>$request->addons_price=="" ? 0 : array_sum(explode(',',$request->addons_price)),
                "variation_id"=>$request->variation_id,
                "variation_name"=>$request->variation_name,
                "qty"=>1,
            ];
            session()->put('cartdata', $cart);
            return response()->json(['status'=>1,'message'=>trans('messages.success'), 'data'=>$cart], 200);
        } catch (\Throwable $th) {
            return response()->json(['status'=>0,'message'=>trans('messages.wrong')], 200);
        }
    }
    public function show(Request $request)
    {
        $iteminfo = Item::with(['variation','subcategory_info','category_info','item_image'])->where('item.id','=',$request->id)->where('item.item_status','1')->where('item.is_deleted','2')->first();
        $itemdata = array(
            "id"=>$iteminfo->id,
            "item_name"=>$iteminfo->item_name,
            "item_type"=>$iteminfo->item_type,
            "item_type_image"=>$iteminfo->item_type == 1 ? helper::image_path("veg.svg") : helper::image_path("nonveg.svg"),
            "preparation_time"=>$iteminfo->preparation_time,
            "price"=>$iteminfo->price,
            "is_featured"=>$iteminfo->is_featured,
            "tax"=>$iteminfo->tax,
            // "image_name"=>$iteminfo->image,
            // "image_url"=>Helper::image_path($iteminfo->image),
            "image_name"=>$iteminfo['item_image']->image_name,
            "image_url"=>$iteminfo['item_image']->image_url,
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
    public function checkout(Request $request){
        return view('admin.pos.checkout');
    }
    public function qtyupdate(Request $request)
    {
        if($request->id) {
            $cartdata = session()->get('cartdata');
            if ($request->type == "minus") {
                if($cartdata[$request->id]['qty'] == 1){
                    unset($cartdata[$request->id]);
                }else{
                    $cartdata[$request->id]['qty']--;
                }
            } else {
                $cartdata[$request->id]['qty']++;
            }
            session()->put('cartdata', $cartdata);
            session()->forget('discount_amount');
            return response()->json(['status'=>1,'message'=>trans('messages.success')], 200);
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.wrong')], 200);
        }
    }
    public function deleteitem(Request $request)
    {
        if($request->id) {
            $cartdata = session()->get('cartdata');
            unset($cartdata[$request->id]);
            session()->put('cartdata', $cartdata);
            session()->forget('discount_amount');
            return response()->json(['status'=>1,'message'=>trans('messages.success')], 200);
        }else{
            return response()->json(['status'=>1,'message'=>trans('messages.wrong')], 200);
        }
    }
    public function applydiscount(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'amount' => 'required|numeric|lt:sub_total',
        ],[
            "amount.required"=>trans('messages.amount_required'),
            "amount.numeric"=>trans('messages.numbers_only'),
            "amount.lt"=>trans('messages.amount_less_then').' : '.helper::currency_format($request->sub_total),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            session()->put('discount_amount', $request->amount);
            return redirect()->back()->with('success',trans('messages.success'));
        }
    }
    public function removediscount(Request $request)
    {
        session()->forget('discount_amount');
        return redirect()->back()->with('success',trans('messages.success'));
    }
    public function placeorder(Request $request)
    {
        if ($request->grand_total == "NaN") {
            return response()->json(['status'=>0,'message'=> trans('messages.cart_is_empty')],200);
        }
        try {
            $order_number = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 10)), 0, 10);
            $order = new Order;
            $order->order_number = $order_number;
            $order->user_id = Auth::user()->id;
            $order->order_type = 2;
            $order->discount_amount = $request->discount_amount;
            $order->tax_amount = $request->tax;
            $order->grand_total = $request->grand_total;
            $order->transaction_type = 1;
            $order->status = 2;
            $order->order_from = 'pos';
            $order->is_notification = 1;
            $order->save();
            foreach(session()->get('cartdata') as $details) {
                $order_details = new OrderDetails;
                $order_details->user_id = Auth::user()->id;
                $order_details->order_id = $order->id;
                $order_details->item_id = $details['item_id'];
                $order_details->item_name = $details['item_name'];
                $order_details->item_image = $details['image_name'];
                $order_details->item_type = $details['item_type'];
                $order_details->addons_id = $details['addons_id'];
                $order_details->addons_name = $details['addons_name'];
                $order_details->addons_price = $details['addons_price'];
                $order_details->variation_id = $details['variation_id'];
                $order_details->variation = $details['variation_name'];
                $order_details->item_price = $details['item_price'];
                $order_details->tax = $details['tax'];
                $order_details->qty = $details['qty'];
                $order_details->save();
            }
            session()->forget('cartdata');
            session()->forget('discount_amount');
            return response()->json(['status'=>1,'message'=>trans('messages.order_placed')]);
        } catch (\Exception $e) {
            // session()->put('error',$e->getMessage());
            return redirect()->back()->with('error',trans('messages.wrong'));
        }
    }
    public function orders(Request $request)
    {
        $getorders = Order::with('user_info','driver_info')->where('order_from','=','pos')->select('order.*')->orderByDesc('id')->get();
        $getdriver = User::where('type','3')->where('is_available',1)->orderByDesc('id')->get();
        return view('admin.pos.orders',compact('getorders','getdriver'));
    }
}
