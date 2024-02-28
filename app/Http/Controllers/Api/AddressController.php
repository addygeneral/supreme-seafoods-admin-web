<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Models\Address;
use App\Models\User;
use App\Models\Zone;
class AddressController extends Controller
{
    public function getaddress(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
        }
        $checkuser = User::where('is_available',1)->where('id',$request->user_id)->first();
        if(!empty($checkuser)){
            try {
                $address=Address::select('id','user_id','address_type','address','lat','lang','area','house_no')->where('user_id',$request->user_id)->orderbyDesc('id')->get();
                return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$address],200);
            } catch (\Exception $e){
                return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
            }
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
        }
    }
    public function addaddress(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
        }
        if($request->address_type == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.address_type_required')],200);
        }
        if($request->address == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.address_required')],200);
        }
        if($request->lat == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.select_address')],200);
        }
        if($request->lang == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.select_address')],200);
        }
        if($request->house_no == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.house_no_required')],200);
        }
    $checkzone = helper::checkzone($request->lat,$request->lang);
    if(!$checkzone){
            return response()->json(['status'=>2,'message'=>trans('messages.delivery_not_available')],200);
        }
        try {
            $address = new Address;
            $address->user_id = $request->user_id;
            $address->address_type = $request->address_type;
            $address->address = $request->address;
            $address->lat = $request->lat;
            $address->lang = $request->lang;
            $address->area = $request->area;
            $address->house_no = $request->house_no;
            $address->save();
            return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
        } catch (\Exception $e){
            return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
        }
    }
    public function updateaddress(Request $request)
    {
        if($request->address_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.address_required')],200);
        }
        $checkaddress = Address::find($request->address_id);
        if(!empty($checkaddress)){
            if($request->address_type == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.address_type_required')],200);
            }
            if($request->address == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.address_required')],200);
            }
            if($request->lat == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.select_address')],200);
            }
            if($request->lang == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.select_address')],200);
            }
            if($request->house_no == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.house_no_required')],200);
            }
        $checkzone = helper::checkzone($request->lat,$request->lang);
        if(!$checkzone){
                return response()->json(['status'=>2,'message'=>trans('messages.delivery_not_available')],200);
            }
            try {
                $checkaddress->address_type = $request->address_type;
                $checkaddress->address = $request->address;
                $checkaddress->lat = $request->lat;
                $checkaddress->lang = $request->lang;
                $checkaddress->area = @$request->area;
                $checkaddress->house_no = $request->house_no;
                $checkaddress->save();
                return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
            } catch (\Exception $e){
                return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
            }
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_address')],200);
        }
    }
    public function deleteaddress(Request $request)
    {
        if($request->address_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.address_required')],200);
        }
        $checkaddress = Address::find($request->address_id);
        if(!empty($checkaddress)){
            try {
                $checkaddress->delete(); 
                return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
            } catch (\Exception $e){
                return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
            }
        }else{
            return response()->json(['status'=>0,'message'=>trans('messages.invalid_address')],200);
        }
    }
}
