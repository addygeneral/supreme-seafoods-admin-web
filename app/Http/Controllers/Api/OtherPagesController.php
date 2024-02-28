<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blogs;
use App\Models\Gallery;
use App\Models\Team;
use App\Models\Faq;
use App\Models\Tutorial;
use App\Models\PrivacyPolicy;
use App\Models\TermsCondition;

class OtherPagesController extends Controller
{
    public function blogs(Request $request)
    {
        $getblogs = Blogs::select('id','title','description',\DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as date'),\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/about')."/', image) AS image_url"))->orderBydesc('id')->get();
        return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$getblogs],200);
    }
    public function ourteam(Request $request)
    {
        $getteams = Team::select("id","title","subtitle","fb","youtube","insta","description",\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/about')."/', image) AS image_url"))->orderBydesc('id')->get();
        return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$getteams],200);
    }
    public function tutorial(Request $request)
    {
        $gettutorials = Tutorial::select("id","title","description",\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/about')."/', image) AS image_url"))->orderBydesc('id')->get();
        return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$gettutorials],200);
    }
    public function faq(Request $request)
    {
        $getfaqs = Faq::select("id","title","description")->orderBydesc('id')->get();
        return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$getfaqs],200);
    }
    public function gallery(Request $request)
    {
        $getgalleries = Gallery::select(\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/about')."/', image) AS image_url"))->orderBydesc('id')->get();
        return response()->json(['status'=>1,'message'=>trans('messages.success'),'data'=>$getgalleries],200);
    }
    public function cmspages(Request $request)
    {
        $privacypolicy = PrivacyPolicy::select('privacypolicy_content')->first();
        $termscondition = TermsCondition::select('termscondition_content')->first();
        return response()->json(['status'=>1,'message'=>trans('messages.success'),'privacypolicy'=>$privacypolicy->privacypolicy_content,'termscondition'=>$termscondition->termscondition_content],200);
    }
}
