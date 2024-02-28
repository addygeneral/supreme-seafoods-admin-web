<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promocode;
use App\Models\User;
use App\Models\Order;
class PromocodeController extends Controller
{
    public function promocodelist()
    {
        $promocode=Promocode::select('offer_name','offer_code','offer_type','offer_amount','min_amount','per_user','usage_type','usage_limit','start_date','expire_date','description')->where('is_available',1)->get();
        return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$promocode],200);
    }
    public function checkpromocode(Request $request)
    {
      
            if($request->offer_code == ""){
                return response()->json(["status"=>0,"message"=>trans('messages.offercode_required')],200);
            }
            $checkoffercode = Promocode::where('offer_code',$request->offer_code)->where('is_available',1)->first();
            if(!empty($checkoffercode)){
                if ((date('Y-m-d') >= $checkoffercode->start_date) && (date('Y-m-d') <= $checkoffercode->expire_date))
                {
                    $checkcount=Order::select('offer_code')->where('offer_code',$request->offer_code)->count();
                    if($checkoffercode->usage_type == 1){
                        if($checkcount < $checkoffercode->usage_limit){
                            return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$checkoffercode],200);
                        }else{
                            return response()->json(['status'=>0,'message'=>trans('messages.usage_limit_exceeded')],200);
                            // return response()->json(['status'=>0,'message'=>trans('messages.once_per_user')],200);
                        }
                    }else{
                        // if($checkcount < $checkoffercode->per_user){
                            return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$checkoffercode],200);
                        // }else{
                        //     return response()->json(['status'=>0,'message'=>trans('messages.usage_limit_exceeded')],200);
                        // }
                    }
                }else{
                    return response()->json(["status"=>0,"message"=>trans('messages.offer_expired')],200);   
                }
            }else{
                return response()->json(['status'=>0,'message'=>trans('messages.invalid_promocode')],200);
            }
       
    }
}
