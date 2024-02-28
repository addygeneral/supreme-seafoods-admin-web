<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Models\Addons;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;
class AddonsController extends Controller
{
    public function index(){
        $getaddons = Addons::where('is_deleted','2')->orderByDesc('id')->get();
        return view('admin.addons.addons',compact('getaddons'));
    }
    public function add(){
        return view('admin.addons.add');
    }
    public function list(){
        $getaddons = Addons::where('is_deleted','2')->orderByDesc('id')->get();
        return view('admin.addons.addonstable',compact('getaddons'));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'type' => 'required',
            'price' => 'required_if:type,2',
        ],[
            "name.required"=>trans('messages.addons_name_required'),
            "type.required"=>trans('messages.type_required'),
            "price.required_if"=>trans('messages.price_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $addons = new Addons;
            $addons->name = $request->name;
            $addons->price = helper::number_format($request->type == 1 ? 0 : $request->price);
            $addons->save();
            return redirect('admin/addons')->with('success',trans('messages.success'));
        }
    }
    public function show(Request $request){
        $addonsdata = Addons::findorFail($request->id);
        return view('admin.addons.edit',compact('addonsdata'));
    }
    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'type' => 'required',
            'price' => 'required_if:type,2',
        ],[
            "name.required"=>trans('messages.addons_name_required'),
            "type.required"=>trans('messages.type_required'),
            "price.required_if"=>trans('messages.price_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $addons = Addons::find($request->id);
            $addons->name = $request->name;
            $addons->price = helper::number_format($request->type == 1 ? 0 : $request->price);
            $addons->save();
            return redirect('admin/addons')->with('success',trans('messages.success'));
        }
    }
    public function destroy(Request $request){
        $addons=Addons::where('id', $request->id)->delete();
        if ($addons) {
            return 1;
        } else {
            return 0;
        }
    }
    public function status(Request $request){
        $category = Addons::where('id', $request->id)->update( array('is_available'=>$request->status) );
        if ($category) {
            Cart::where('addons_id', 'LIKE', '%' . $request->id . '%')->delete();
            return 1;
        } else {
            return 0;
        }
    }
    public function delete(Request $request){
        $UpdateDetails = Addons::where('id', $request->id)->update(['is_deleted' => '1']);
        if ($UpdateDetails) {
            Cart::where('addons_id', 'LIKE', '%' . $request->id . '%')->delete();
            return 1;
        } else {
            return 0;
        }
    }
}
