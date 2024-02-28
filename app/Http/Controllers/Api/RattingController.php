<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ratting;
use App\Helpers\helper;
use Illuminate\Support\Facades\DB;
class RattingController extends Controller
{
    public function ratting(Request $request)
    {
      	if($request->user_id == ""){
          	return response()->json(["status"=>0,"message"=>trans('messages.user_required')],200);
      	}
      	if(!helper::check_review_exist($request->user_id)) {
			$ratting = new Ratting;
			$ratting->user_id =$request->user_id;
			$ratting->ratting =$request->ratting;
			$ratting->comment =$request->comment;
			$ratting->save();
			return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
		} else {
			return response()->json(['status'=>0,'message'=>trans('messages.review_exist')],200);
		}
   	}
    public function rattinglist(Request $request)
    {
		$testimonials = Ratting::join('users','users.id','ratting.user_id')
					->select('ratting.id','ratting.ratting','ratting.comment',DB::raw('DATE_FORMAT(ratting.created_at, "%d-%m-%Y") as date'),'ratting.user_id','users.name',
						DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/profile/')."/', users.profile_image) AS profile_image"))
					->orderByDesc('ratting.id')->get();

		return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$testimonials,'check_review_exist'=>helper::check_review_exist($request->user_id)],200);
    }
}
