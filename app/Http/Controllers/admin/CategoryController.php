<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Item;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    public function index(){
        $getcategory = Category::where('is_deleted','2')->orderBy('reorder_id')->get();
        return view('admin.category.category',compact('getcategory'));
    }
    public function add(){
        return view('admin.category.add');
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'category_name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ],[
            "category_name.required"=>trans('messages.category_name_required'),
            "image.required"=>trans('messages.image_required'),
            "image.image"=>trans('messages.enter_image_file'),
            "image.mimes"=>trans('messages.valid_image'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $image = 'category-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(env('ASSETSPATHURL').'admin-assets/images/category', $image);
            $category = new Category;
            $category->image = $image;
            $category->category_name = $request->category_name;
            $category->slug = $this->getcategoryslug($request->category_name,'');
            $category->save();
            return redirect('admin/category')->with('success', trans('messages.success'));
        }
    }
    public function show(Request $request){
        $catdata = Category::where('id',$request->id)->first();
        return view('admin.category.edit',compact('catdata'));
    }
    public function update(Request $request){
        $validator = Validator::make($request->all(),
            ['category_name' => 'required',],
            ["category_name.required"=>trans('messages.category_name_required'),]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $category = Category::find($request->id);
            if($request->file('image') != ""){
                $validator = Validator::make($request->all(),
                ['image' => 'required|image|mimes:jpeg,png,jpg',],
                ["image.required"=>trans('messages.image_required'),
                "image.image"=>trans('messages.enter_image_file'),
                "image.mimes"=>trans('messages.valid_image'),]);
                if ($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    if(file_exists(env('ASSETSPATHURL').'admin-assets/images/category/'.$category->image)){
                        unlink(env('ASSETSPATHURL').'admin-assets/images/category/'.$category->image);
                    }
                    $image = 'category-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
                    $request->image->move(env('ASSETSPATHURL').'admin-assets/images/category', $image);
                    $category->image = $image;
                    $category->save();
                }
            }
            $category->category_name = $request->category_name;
            $category->slug = $this->getcategoryslug($request->category_name,$request->id);
            $category->save();
            return redirect('admin/category')->with('success', trans('messages.success'));
        }
    }
    public function status(Request $request){
        $category = Category::where('id', $request->id)->update( array('is_available'=>$request->status) );
        if ($category) {
            $item = Item::where('cat_id', $request->id)->update( array('item_status'=>$request->status) );
            $items = Item::where('cat_id', $request->id)->get();
            foreach ($items as $value) {
                $UpdateCart = Cart::where('item_id', $value['id'])->delete();
            }
            return 1;
        } else {
            return 0;
        }
    }
    public function delete(Request $request){
        $category = Category::where('id', $request->id)->first();
        $updatecategory = Category::where('id', $request->id)->update( array('is_deleted'=>'1') );
        if ($updatecategory) {
            $item = Item::where('cat_id', $request->id)->update( array('is_deleted'=>'1') );
            $items = Item::where('cat_id', $request->id)->get();
            foreach ($items as $value) {
                $UpdateCart = Cart::where('item_id', $value['id'])->delete();
            }
            if(file_exists(env('ASSETSPATHURL').'admin-assets/images/category/'.$category->image)){
                unlink(env('ASSETSPATHURL').'admin-assets/images/category/'.$category->image);
            }
            return 1;
        } else {
            return 0;
        }
    }
    public function getcategoryslug($category_name, $id)
    {
        $slug = Str::slug($category_name,'-');
        $checkslug = Category::where('slug',$slug);
        if($id != ""){
            $checkslug = $checkslug->where('id','!=',$id);
        }
        $checkslug = $checkslug->first();
        if(!empty($checkslug)){
            $lastid = Category::select('id')->orderByDesc('id')->first();
            $slug .= '-'.$lastid->id;
        }
        return $slug;
    }

    public function reorder_category(Request $request)
    {
        $getcategory = Category::all();
        foreach ($getcategory as $category) {
            foreach ($request->order as $order) {
               $category = Category::where('id',$order['id'])->first();
               $category->reorder_id = $order['position']; 
               $category->save();
            }
        }
        return response()->json(['status' => 1,'msg' =>'Update Successfully!!'], 200);
    }





    
    // subcategory
    public function subcategory_index(Request $request){
        $getsubcategory = Subcategory::with('category_info')->where('is_deleted',2)->orderByDesc('id')->get();
        return view('admin.subcategory.index',compact('getsubcategory'));
    }
    public function subcategory_add(Request $request){
        $getcategory = Category::where('is_available',1)->where('is_deleted',2)->orderByDesc('id')->get();
        return view('admin.subcategory.add',compact('getcategory'));
    }
    public function subcategory_store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'category' => 'required',
        ],[
            "name.required"=>trans('messages.subcategory_name_required'),
            "category.required"=>trans('messages.category_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $subcategory = new Subcategory;
            $subcategory->subcategory_name = $request->name;
            $subcategory->cat_id = $request->category;
            $subcategory->slug = $this->getsubcategoryslug($request->name,'');
            $subcategory->save();
            return redirect('admin/sub-category')->with('success', trans('messages.success'));
        }
    }
    public function subcategory_status(Request $request){
        $subcategory = Subcategory::where('id', $request->id)->update( ['is_available'=>$request->status] );
        if ($subcategory) {
            $item = Item::where('subcat_id', $request->id)->update( ['item_status'=>$request->status] );
            $items = Item::where('subcat_id', $request->id)->get();
            foreach ($items as $value) {
                $UpdateCart = Cart::where('item_id', $value['id'])->delete();
            }
            return 1;
        } else {
            return 0;
        }
    }
    public function subcategory_delete(Request $request){
        $category = Subcategory::where('id', $request->id)->update( ['is_deleted'=>'1'] );
        if ($category) {
            $item = Item::where('subcat_id', $request->id)->update( ['is_deleted'=>'1'] );
            $items = Item::where('subcat_id', $request->id)->get();
            foreach ($items as $value) {
                $UpdateCart = Cart::where('item_id', $value['id'])->delete();
            }
            return 1;
        } else {
            return 0;
        }
    }
    public function subcategory_show(Request $request){
        $subcatdata = Subcategory::where('id',$request->id)->first();
        $getcategory = Category::where('is_available',1)->where('is_deleted',2)->orderByDesc('id')->get();
        return view('admin.subcategory.edit',compact('subcatdata','getcategory'));
    }
    public function subcategory_update(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'category' => 'required',
        ],[
            "name.required"=>trans('messages.subcategory_name_required'),
            "category.required"=>trans('messages.category_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $subcategory = Subcategory::find($request->id);
            $subcategory->subcategory_name = $request->name;
            $subcategory->cat_id = $request->category;
            $subcategory->slug = $this->getsubcategoryslug($request->name,$request->id);
            $subcategory->save();
            return redirect('admin/sub-category')->with('success', trans('messages.success'));
        }
    }
    public function getsubcategoryslug($subcategory_name, $id)
    {
        $slug = Str::slug($subcategory_name,'-');
        $checkslug = Subcategory::where('slug',$slug);
        if($id != ""){
            $checkslug = $checkslug->where('id','!=',$id);
        }
        $checkslug = $checkslug->first();
        if(!empty($checkslug)){
            $lastid = Subcategory::select('id')->orderByDesc('id')->first();
            $slug .= '-'.$lastid->id;
        }
        return $slug;
    }
}
