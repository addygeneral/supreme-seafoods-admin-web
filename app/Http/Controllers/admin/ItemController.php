<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Item;
use App\Models\Variation;
use App\Models\Addons;
use App\Models\ItemImages;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class ItemController extends Controller
{
    public function index(Request $request) {
        $getitem = Item::with('category_info','subcategory_info','variation','item_image')->select('item.*')->join('categories','item.cat_id','=','categories.id')->where('item.is_deleted','2')->where('categories.is_available','1')->orderBy('item.reorder_id');
        if($request->has('search') && $request->search != "" ){
            $search = $request->search;
            $getitem = $getitem->where(function ($query) use($search){
                        $query->where('item.item_name', 'like','%'.$search.'%');
                    });
        }
        if($request->has('option') && $request->option != "" ){
            $getitem = $getitem->where('item.item_type',$request->option == "veg" ? 1 : 2);
        }
        $getitem = $getitem->orderByDesc('item.id')->get();
        return view('admin.item.item', compact('getitem'));
    }
    public function additem() {
        $getcategory = Category::where('is_available','1')->where('is_deleted','2')->get();
        $getaddons = Addons::where('is_deleted','2')->where('is_available','1')->get();
        return view('admin.item.additem', compact('getcategory','getaddons'));
    }
    public function edititem($id) {
        $getitem = Item::find($id);
        $getitemimages = ItemImages::where('item_id',$id)->orderByDesc('id')->get();
        $getcategory = Category::where('is_available','1')->where('is_deleted','2')->get();
        $getsubcategory = Subcategory::where('cat_id',$getitem->cat_id)->where('is_available','1')->where('is_deleted','2')->get();
        $getaddons = Addons::where('is_deleted','2')->where('is_available','1')->get();
        $getvariation = Variation::where('item_id', $id)->get();
        return view('admin.item.edititem', compact('getitem','getcategory','getsubcategory','getaddons','getvariation','getitemimages'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'cat_id' => 'required',
            'preparation_time' => 'required',
            'item_name' => 'required',
            'image' => 'required',
            'image.*' => 'required',
            'item_type' => 'required',
            'has_variation' => 'required',
            'price' => 'required_if:has_variation,2',
            'attribute' => 'required_if:has_variation,1',
            'variation.*' => 'required_if:has_variation,1',
            'product_price.*' => 'required_if:has_variation,1',
        ],[ 
            "cat_id.required"=>trans('messages.category_required'),
            "preparation_time.required"=>trans('messages.preparation_time_required'),
            "item_name.required"=>trans('messages.item_name_required'),
            "image.required"=>trans('messages.image_required'),
            "image.*.required"=>trans('messages.image_required'),
            "item_type.required"=>trans('messages.item_type_required'),
            "attribute.required_if"=>trans('messages.attribute_required'),
            "variation.*.required_if"=>trans('messages.variation_name_required'),
            "product_price.*.required_if"=>trans('messages.product_price_required'),
            "product_price.*.numeric"=>trans('messages.numbers_only'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            // $img = $request->file('image');
            // $image = 'item-' . uniqid() . '.' . $img->getClientOriginalExtension();
            $item = new Item;
            $item->cat_id = $request->cat_id;
            $item->subcat_id = $request->subcat_id == "" ? "" : $request->subcat_id;
            $item->preparation_time = $request->preparation_time;
            $item->addons_id = $request->addons_id!="" ? @implode(",",$request->addons_id) : null ;
            $item->item_name = $request->item_name;
            $item->slug = $this->getitemslug($request->item_name,'');
            $item->item_type = $request->item_type;
            $item->has_variation = $request->has_variation;
            if($request->has_variation == 2){
                $item->price = helper::number_format($request->price);
                $item->attribute = "";
            }else{
                $item->price = helper::number_format(0);
                $item->attribute = $request->attribute;
            }
            $item->image = @$image;
            $item->item_description = $request->description;
            $item->tax = $request->tax;
            if ($item->save()) {
                if($request->has_variation == 1 && $request->product_price !=""){
                    $product_price = $request->product_price;
                    $sale_price = $request->sale_price;
                    $variation = $request->variation;
                    foreach($product_price as $key => $no){
                        $input['item_id'] = $item->id;
                        $input['product_price'] = helper::number_format($no);
                        $input['sale_price'] = helper::number_format(0);
                        $input['variation'] = $variation[$key];
                        Variation::create($input);
                    }
                }
                // $img->move(env('ASSETSPATHURL').'admin-assets/images/item', $image);
                foreach($request->file('image') as $img){
                    $itemimage = new ItemImages;
                    $image = 'item-' . uniqid() . '.' . $img->getClientOriginalExtension();
                    $img->move(env('ASSETSPATHURL').'admin-assets/images/item', $image);
                    $itemimage->item_id = $item->id;
                    $itemimage->image = $image;
                    $itemimage->save();
                }
                return redirect('admin/item')->with('success', trans('messages.success'));
            } else {
                return redirect()->back()->with('error', trans('messages.wrong'));
            }
        }
    }
    public function storeimages(Request $request){
        $validation = Validator::make($request->all(),[
          'file.*' => 'required'
        ]);
        $error_array = array();
        $success_output = '';
        if ($validation->fails()){
            foreach($validation->messages()->getMessages() as $field_name => $messages){
                $error_array[] = $messages;
            }
        }else{
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                foreach($files as $file){
                    $itemimage = new ItemImages;
                    $image = 'item-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(env('ASSETSPATHURL').'admin-assets/images/item', $image);
                    $itemimage->item_id = $request->itemid;
                    $itemimage->image = $image;
                    $itemimage->save();
                }
            }
            $success_output = trans('messages.success');
        }
        $output = array('error'     =>  $error_array,'success'   =>  $success_output);
        echo json_encode($output);
    }
    public function showimage(Request $request)
    {
        // $getitem = Item::where('id',$request->id)->first();
        // if($getitem->image){
        //     $getitem->img=url(env('ASSETSPATHURL').'admin-assets/images/item/'.$getitem->image);
        // }
        $getitem = ItemImages::where('id',$request->id)->first();
        if($getitem->image){
            $getitem->img=url(env('ASSETSPATHURL').'admin-assets/images/item/'.$getitem->image);
        }
        return response()->json(['ResponseCode' => 1, 'ResponseText' => trans('messages.success'), 'ResponseData' => $getitem], 200);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'cat_id' => 'required',
            'preparation_time' => 'required',
            'item_name' => 'required',
            'item_type' => 'required',
            'has_variation' => 'required',
            'price' => 'required_if:has_variation,2',
            'attribute' => 'required_if:has_variation,1',
            'variation.*' => 'required_if:has_variation,1',
            'product_price.*' => 'required_if:has_variation,1',
        ],[ 
            "cat_id.required"=>trans('messages.category_required'),
            "preparation_time.required"=>trans('messages.preparation_time_required'),
            "item_name.required"=>trans('messages.item_name_required'),
            "item_type.required"=>trans('messages.item_type_required'),
            "has_variation.required"=>trans('messages.select_option'),
            "price.required_if"=>trans('messages.price_required'),
            "attribute.required_if"=>trans('messages.attribute_required'),
            "variation.*.required_if"=>trans('messages.variation_name_required'),
            "product_price.*.required_if"=>trans('messages.product_price_required'),
            "product_price.*.numeric"=>trans('messages.numbers_only'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $deletefromcart=Cart::where('item_id', $request->id)->delete();
            $item = Item::find($request->id);
            $item->cat_id = $request->cat_id;
            $item->subcat_id = $request->subcat_id == "" ? "" : $request->subcat_id;
            $item->preparation_time = $request->preparation_time;
            $item->addons_id = $request->addons_id!="" ? @implode(",",$request->addons_id) : null ;
            $item->item_type = $request->item_type;
            $item->has_variation = $request->has_variation;
            if($request->has_variation == 2){
                $item->price = helper::number_format($request->price);
                $item->attribute = "";
            }else{
                $item->price = helper::number_format(0);
                $item->attribute = $request->attribute;
            }
            $item->item_name = $request->item_name;
            $item->slug = $this->getitemslug($request->item_name,$request->id);;
            $item->item_description = $request->description;
            $item->tax = $request->tax;
            $item->save();
            if($request->has_variation == 2){
                Variation::where('item_id',$request->id)->delete();
            }
            if($request->has_variation == 1 && $request->product_price !=""){
                $product_price = $request->product_price;
                $sale_price = $request->sale_price;
                $variation = $request->variation;
                $variation_id = $request->variation_id;
                foreach($product_price as $key => $no){
                    if ($variation_id[$key] == "") {
                        $input['item_id'] = $request->id;
                        $input['product_price'] = helper::number_format($no);
                        $input['sale_price'] = helper::number_format(0);
                        $input['variation'] = $variation[$key];
                        Variation::create($input);
                    } 
                    if ($variation_id[$key] != "") {
                        $UpdateCart = Variation::where('id', $variation_id[$key])->update(['product_price' => helper::number_format($no),'variation'=>$variation[$key],'sale_price'=>helper::number_format(0)]);
                    }
                }
            }
            if ($item) {
                return redirect('admin/item')->with('success', trans('messages.success'));
            } else {
                return redirect()->back()->with('error', trans('messages.wrong'));
            }
        }
    }


    public function reorder_item(Request $request)
    {
        $getitem = Item::all();
        foreach ($getitem as $item) {
            foreach ($request->order as $order) {
               $it = Item::where('id',$order['id'])->first();
               $it->reorder_id = $order['position']; 
               $it->save();
            }
        }
        return response()->json(['status' => 1,'msg' =>'Update Successfully!!'], 200);
    }


    public function updateimage(Request $request){
        $validation = Validator::make($request->all(),['image' => 'image']);
        $error_array = array();
        $success_output = '';
        if ($validation->fails()){
            foreach($validation->messages()->getMessages() as $field_name => $messages){
                $error_array[] = $messages;
            }
        }else{
            $itemimage = ItemImages::find($request->id);
            if($request->hasFile('image')){
                $image = 'item-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(env('ASSETSPATHURL').'admin-assets/images/item', $image);
                $itemimage->image = $image;
            }
            $itemimage->save();
            $success_output = trans('messages.success');
        }
        $output = array('error'=>$error_array,'success'=>$success_output);
        echo json_encode($output);
    }
    public function getitemslug($item_name, $id)
    {
        $slug = Str::slug($item_name,'-');
        $checkslug = Item::where('slug',$slug);
        if($id != ""){
            $checkslug = $checkslug->where('id','!=',$id);
        }
        $checkslug = $checkslug->first();
        if(!empty($checkslug)){
            $lastid = Item::select('id')->orderByDesc('id')->first();
            $slug .= '-'.$lastid->id;
        }
        return $slug;
    }
    public function status(Request $request){
        $UpdateDetails = Item::where('id', $request->id)->update(['item_status' => $request->status]);
        if ($UpdateDetails) {
            $deletefromcart=Cart::where('item_id', $request->id)->delete();
            return 1;
        } else {
            return 0;
        }
    }
    public function delete(Request $request){
        $UpdateDetails = Item::where('id', $request->id)->update(['is_deleted' => '1']);
        if ($UpdateDetails) {
            $UpdateCart = Cart::where('item_id', @$request->id)->delete();
            return 1;
        } else {
            return 0;
        }
    }
    public function deletevariation(Request $request){
        $checkvariationcount = Variation::where('item_id',$request->item_id)->count();
        if ($checkvariationcount > 1) {
            $UpdateDetails = Variation::where('id', $request->id)->delete();
            if ($UpdateDetails) {
                Cart::where('variation_id', $request->id)->delete();
                return 1;
            } else {
                return 0;
            }
        } else {
            return 2;
        }
    }
    public function destroyimage(Request $request){
        $getitemimages = ItemImages::where('item_id', $request->item_id)->count();
        if ($getitemimages > 1) {
            $itemimage=ItemImages::where('id', $request->id)->delete();
            if ($itemimage) {
               return 1;
            } else {
               return 0;
            }
        } else {
            return 2;
        }
    }
    public function featured(Request $request){
        $updatedata = Item::where('id', $request->id)->update(['is_featured'=>$request->status]);
        if ($updatedata) {
            return 1;
        } else {
            return 0;
        }
    }
    public function subcategories(Request $request){
        $data = Subcategory::where('cat_id', $request->id)->orderByDesc('id')->where('is_available',1)->where('is_deleted',2)->get();
        return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$data],200);
    }
}
