<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Helpers\helper;
use Illuminate\Support\Facades\Auth;
use Session;
class AddressController extends Controller
{
    public function index(Request $request)
    {
        $getaddresses = Address::select('id','user_id','address_type','address','lat','lang','area','house_no')->where('user_id',Auth::user()->id)->orderbyDesc('id')->get();
        return view('web.address.index', compact('getaddresses'));
    }
    public function add(Request $request)
    {
        session()->put('last_url',url()->previous());
        return view('web.address.add');
    }
    public function store(Request $request)
    {
        if(Auth::user())
        {
            $request->validate([
                'address_type' => 'required',
                'address' => 'required',
                'lat' => 'required_with:address',
                'lang' => 'required_with:lat',
                'house_no' => 'required',
            ],[
                'address_type.required' => trans('messages.address_type_required'),
                'address.required' => trans('messages.address_required'),
                'lat.required_with' => trans('messages.select_address'),
                'lang.required_with' => trans('messages.select_address'),
                'house_no.required' => trans('messages.house_no_required'),
            ]);
            $checkzone = helper::checkzone($request->lat,$request->lang);
           
            if($checkzone == null){
                return redirect()->back()->with('error',trans('messages.delivery_not_available'));
            }else{

                $address = new Address;
                $address->user_id = Auth::user()->id;
                $address->address_type = $request->address_type;
                $address->address = $request->address;
                $address->lat = $request->lat;
                $address->lang = $request->lang;
                $address->house_no = $request->house_no;
                $address->area = $request->area;
                $address->save();
           
                if(strpos(session()->get('last_url'),"checkout")){
                    return redirect('/checkout')->with('success',trans('messages.success'));
                }else{
                    return redirect(route('address'))->with('success',trans('messages.success'));
                }
            }
    
        }
        else
        {
           
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'mobile'=>'required',
                'address' => 'required',
                'lat' => 'required_with:address',
                'lang' => 'required_with:lat',
                'house_no' => 'required',
            ],[
                'name.required' => trans('messages.name_required'),
                'email.required' => trans('messages.email_required'),
                'email.email' => trans('messages.invalid_email'),
                'mobile.required' => trans('messages.mobile_required'),
                'address.required' => trans('messages.address_required'),
                'lat.required_with' => trans('messages.select_address'),
                'lang.required_with' => trans('messages.select_address'),
                'house_no.required' => trans('messages.house_no_required'),
            ]);

            $checkzone = helper::checkzone($request->lat,$request->lang);
           
            if($checkzone == null){
                return redirect()->back()->with('error',trans('messages.delivery_not_available'));
            }else{
                
                $addressdata = [
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'email' => $request->email,
                    'address' => $request->address,
                    'lat' => $request->lat,
                    'lang' => $request->lang,
                    'area' => $request->area,
                    'house_no' => $request->house_no,
                    'delivery_charge' => $checkzone,
                ];

                Session::put('addressdata',$addressdata);
                
                return redirect('/checkout')->with('success',trans('messages.success'));
              
            }
        }
        
    }
    public function show(Request $request)
    {
        if(Auth::user())
        {
        $addressdata = Address::find($request->id);
        }
        else
        {
            $addressdata = Session::get('addressdata');
        }
        if(!empty($addressdata)){
            return view('web.address.update',compact('addressdata'));
        }
        return redirect()->back()->with('error'.trans('messages.wrong'));
    }


    public function update(Request $request)
    {
        if(Auth::user())
        {
            $request->validate([
                'address_type' => 'required',
                'address' => 'required',
                'lat' => 'required_with:address',
                'lang' => 'required_with:lat',
                'house_no' => 'required',
            ],[
                'address_type.required' => trans('messages.address_type_required'),
                'address.required' => trans('messages.address_required'),
                'lat.required_with' => trans('messages.select_address'),
                'lang.required_with' => trans('messages.select_address'),
                'house_no.required' => trans('messages.house_no_required'),
            ]);
            $checkaddress = Address::find($request->id);
            if(!empty($checkaddress)){
                $checkzone = helper::checkzone($request->lat,$request->lang);
               
                if($checkzone == null){
                    return redirect()->back()->with('error',trans('messages.delivery_not_available'));
                }else{
                    $checkaddress->address_type = $request->address_type;
                    $checkaddress->address = $request->address;
                    $checkaddress->lat = $request->lat;
                    $checkaddress->lang = $request->lang;
                    $checkaddress->house_no = $request->house_no;
                    $checkaddress->area = $request->area;
                    $checkaddress->save();
                    return redirect(route('address'))->with('success',trans('messages.success'));
                }
            }
        }
        else
        {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'mobile'=>'required',
                'address' => 'required',
                'lat' => 'required_with:address',
                'lang' => 'required_with:lat',
                'house_no' => 'required',
            ],[
                'name.required' => trans('messages.name_required'),
                'email.required' => trans('messages.email_required'),
                'email.email' => trans('messages.invalid_email'),
                'mobile.required' => trans('messages.mobile_required'),
                'address.required' => trans('messages.address_required'),
                'lat.required_with' => trans('messages.select_address'),
                'lang.required_with' => trans('messages.select_address'),
                'house_no.required' => trans('messages.house_no_required'),
            ]);

                $checkzone = helper::checkzone($request->lat,$request->lang);
             
                if($checkzone == null){
                    return redirect()->back()->with('error',trans('messages.delivery_not_available'));
                }else{
                     $addressdata = [
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'email' => $request->email,
                    'address' => $request->address,
                    'lat' => $request->lat,
                    'lang' => $request->lang,
                    'area' => $request->area,
                    'house_no' => $request->house_no,
                    'delivery_charge' => $checkzone,
                ];

                Session::put('addressdata',$addressdata);
                
                return redirect('/checkout')->with('success',trans('messages.success'));
                }
        }
        
        return redirect()->back()->with('error',trans('messages.wrong'));
    }
    public function deleteaddress(Request $request)
    {
        if(Auth::user())
        {
            $checkaddress = Address::find($request->id);
            if(!empty($checkaddress)){
                $checkaddress->delete(); 
                return 1;
            }else{
                return 0;
            }
        }
        else
        {  
            session()->forget('addressdata');
            return 1;
        }
    }
}