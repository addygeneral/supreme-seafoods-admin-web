<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ratting;
use App\Helpers\helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class RattingController extends Controller
{
    public function addreview(Request $request){
        $validator = Validator::make($request->all(),[
            'ratting' => 'required',
            'message' => 'required',
        ],[
            "ratting.required"=>trans('messages.ratting_required'),
            "message.required"=>trans('messages.message_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('error',trans('messages.wrong'));
        }else{
            if(!helper::check_review_exist(Auth::user()->id)) {
                $ratting = new Ratting;
                $ratting->user_id = Auth::user()->id;
                $ratting->ratting = $request->ratting;
                $ratting->comment = $request->message;
                $ratting->save();
                return redirect()->back()->with('success',trans('messages.success'));
            } else {
                return redirect()->back()->with('error',trans('messages.review_exist'));
            }
        }
    }
}
