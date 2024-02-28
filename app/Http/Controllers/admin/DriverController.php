<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
class DriverController extends Controller
{
    public function index(){
        $getdriverlist = User::where('type','3')->orderByDesc('id')->paginate(12);
        return view('admin.driver.driver',compact('getdriverlist'));
    }
    public function add(){
        return view('admin.driver.add');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users',
            'mobile' => 'required|unique:users',
            'password' => 'required',
            'identity_type' => 'required',
            'identity_number' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ],[
            "name.required"=>trans('messages.name_required'),
            "email.required"=>trans('messages.email_required'),
            "email.unique"=>trans('messages.email_exist'),
            "mobile.required"=>trans('messages.mobile_required'),
            "mobile.unique"=>trans('messages.mobile_exist'),
            "password.required"=>trans('messages.password_required'),
            "identity_type.required"=>trans('messages.identity_type_required'),
            "identity_number.required"=>trans('messages.identity_number_required'),
            "image.required"=>trans('messages.image_required'),
            "image.image"=>trans('messages.enter_image_file'),
            "image.mimes"=>trans('messages.valid_image'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{

            $image = 'identity-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(env('ASSETSPATHURL').'admin-assets/images/profile', $image);

            $driver = new User;
            $driver->name = $request->name;
            $driver->email = $request->email;
            $driver->mobile = $request->mobile;
            $driver->profile_image = "unknown.png";
            $driver->identity_image = $image;
            $driver->identity_type = $request->identity_type;
            $driver->identity_number = $request->identity_number;
            $driver->password = Hash::make($request->password);
            $driver->type = "3";
            $driver->save();
            return redirect('admin/driver')->with('success', trans('messages.success'));
        }
    }
    public function show(Request $request){
        $getdriverdata = User::find($request->id);
        return view('admin.driver.edit',compact('getdriverdata'));
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $request->id,
            'mobile' => 'required|unique:users,mobile,' . $request->id,
            'identity_type' => 'required',
            'identity_number' => 'required',
        ],[
            "name.required"=>trans('messages.name_required'),
            "email.required"=>trans('messages.email_required'),
            "email.unique"=>trans('messages.email_exist'),
            "mobile.required"=>trans('messages.mobile_required'),
            "mobile.unique"=>trans('messages.mobile_exist'),
            "identity_type.required"=>trans('messages.identity_type_required'),
            "identity_number.required"=>trans('messages.identity_number_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $driver = User::find($request->id);
            if($request->file('image') != ""){
                $validator = Validator::make($request->all(),
                ['image' => 'required|image|mimes:jpeg,png,jpg',],
                ["image.required"=>trans('messages.image_required'),
                "image.image"=>trans('messages.enter_image_file'),
                "image.mimes"=>trans('messages.valid_image'),]);
                if ($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    if(file_exists(env('ASSETSPATHURL').'admin-assets/images/profile/'.$driver->identity_image)){
                        unlink(env('ASSETSPATHURL').'admin-assets/images/profile/'.$driver->identity_image);
                    }
                    $image = 'identity-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
                    $request->image->move(env('ASSETSPATHURL').'admin-assets/images/profile', $image);
                    $driver->identity_image = $image;
                    $driver->save();
                }
            }
            $driver->name = $request->name;
            $driver->email = $request->email;
            $driver->mobile = $request->mobile;
            $driver->identity_type = $request->identity_type;
            $driver->identity_number = $request->identity_number;
            $driver->save();
            return redirect('admin/driver')->with('success', trans('messages.success'));
        }
    }
    public function status(Request $request){
        $users = User::where('id', $request->id)->update( array('is_available'=>$request->status) );
        if ($users) {
            return 1;
        } else {
            return 0;
        }
    }
    public function driverdetails(Request $request)
    {
        $getdriverdata = User::where('id',$request->id)->first();
        $getorders = Order::with('user_info','driver_info')->where('driver_id',$request->id)->get();

        $totalprocessing = Order::whereNotIn('status',array(5,6,7))->where('driver_id',$request->id)->count();
        $totalcompleted = Order::where('status',5)->where('driver_id',$request->id)->count();

        return view('admin.driver.driverdetails',compact('getdriverdata','getorders','totalprocessing','totalcompleted'));
    }
}
