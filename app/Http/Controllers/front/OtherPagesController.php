<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Models\Blogs;
use App\Models\Gallery;
use App\Models\Team;
use App\Models\Faq;
use App\Models\Tutorial;
use App\Models\PrivacyPolicy;
use App\Models\RefundPolicy;
use App\Models\TermsCondition;
use App\Models\About;
use App\Models\Contact;
use App\Models\Time;
use App\Models\Ratting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class OtherPagesController extends Controller
{
    public function faq(Request $request){
        $getfaqs = Faq::select("id","title","description")->orderBydesc('id')->get();
        return view('web.faq', compact('getfaqs'));
    }
    public function privacypolicy(Request $request){
        $getprivacypolicy = PrivacyPolicy::first();
        return view('web.privacypolicy', compact('getprivacypolicy'));
    }
    public function termsconditions(Request $request){
        $gettermscondition = TermsCondition::first();
        return view('web.termsconditions', compact('gettermscondition'));
    }
    public function gallery(Request $request){
        $getgalleries = Gallery::select(\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/about')."/', image) AS image_url"))->orderByDesc('id')->get();
        return view('web.gallery', compact('getgalleries'));
    }
    public function ourteam(Request $request){
        $getteams = Team::select("id","title","subtitle","fb","youtube","insta","description",\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/about')."/', image) AS image_url"))->orderBydesc('id')->get();
        return view('web.ourteam', compact('getteams'));
    }
    public function aboutus(Request $request){
        $getaboutus = About::first();
        return view('web.aboutus', compact('getaboutus'));
    }
    // blogs
    public function blogs(Request $request){
        $getblogs = Blogs::orderBydesc('id')->get();
        return view('web.blogs.blogs', compact('getblogs'));
    }
    public function showblog(Request $request){
        $getblogdata = Blogs::where('slug',$request->slug)->first();
        $recentblogs = Blogs::orderBydesc('id')->take('3')->get();
        return view('web.blogs.blogdetails', compact('getblogdata','recentblogs'));
    }
    // contact-us
    public function contactindex(Request $request){
        $timedata = Time::where('day',date('l'))->first();
        $gettimings = Time::all();
        return view('web.contactus', compact('timedata','gettimings')); 
    }
    public function contactstore(Request $request){
        $validator = Validator::make($request->all(),[
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ],[
            'fname.required' => trans('messages.first_name_required'),
            'lname.required' => trans('messages.last_name_required'),
            'email.required' => trans('messages.email_required'),
            'message.required' => trans('messages.message_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $contact = new Contact;
            $contact->firstname = $request->fname;
            $contact->lastname = $request->lname;
            $contact->email = $request->email;
            $contact->message = $request->message;
            $contact->save();
            return redirect()->back()->with('success',trans('messages.success'));
        }
    }
    // testimonials
    public function testimonials(Request $request ){
        $testimonials = Ratting::with('user_info')->orderByDesc('ratting.id')->paginate(9);
        return view('web.testimonials', compact('testimonials'));
    }
    // refund-policy
    public function refundpolicy(Request $request){
        $getrefundpolicy = RefundPolicy::first();
        return view('web.refundpolicy', compact('getrefundpolicy'));
    }
}
