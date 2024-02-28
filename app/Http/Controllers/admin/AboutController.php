<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\FooterFeatures;
use Illuminate\Support\Facades\Validator;
use File;
class AboutController extends Controller
{
    public function index(){
        $getsettings = About::first();
        $getfooterfeatures = FooterFeatures::orderByDesc('id')->get();
        return view('admin.cms.settings',compact('getsettings','getfooterfeatures')); 
    }
    public function delete_feature(Request $request){
        FooterFeatures::where('id',$request->id)->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function settings_update(Request $request)
    {
        if ($request->contact_update) {
            $validator = Validator::make($request->all(),[
                'email'=>'required',
                'mobile'=>'required',
                'address'=>'required',
                'lat'=>'required',
                'lang'=>'required',
            ],[
                "email.required"=>trans('messages.email_required'),
                "mobile.required"=>trans('messages.mobile_required'),
                "address.required"=>trans('messages.address_required'),
                "lat.required"=>trans('messages.lat_required'),
                "lang.required"=>trans('messages.lang_required'),
            ]);
            if ($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }
                $about->email = $request->email;
                $about->mobile = $request->mobile;
                $about->fb = $request->fb;
                $about->insta = $request->insta;
                $about->youtube = $request->youtube;
                $about->address = $request->address;
                $about->address = $request->address;
                $about->lat = $request->lat;
                $about->lang = $request->lang;
                $about->save();
            }
        }
        if ($request->thirdparty_update) {
            $validator = Validator::make($request->all(),[
                'map'=>'required',
                'firebase'=>'required',
            ],[
                "map.required"=>trans('messages.map_required'),
                "firebase.required"=>trans('messages.firebase_required'),
            ]);
            if ($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }
                $about->map = $request->map;
                $about->firebase = $request->firebase;
                $about->timezone = $request->timezone;
                $about->save();
            }
        }
        if ($request->seo_update) {
            if($request->hasFile('og_image')){
                $og_image = 'og_image-' . uniqid() . '.' . $request->og_image->getClientOriginalExtension();
                $request->og_image->move(env('ASSETSPATHURL').'admin-assets/images/about', $og_image);
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }else{
                    if($about->og_image != "" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->og_image)){
                        unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->og_image);
                    }
                }
                $about->og_image= $og_image;
                $about->save();
            }
            $about = About::first();
            if(empty($about)){
                $about = new About();
            }
            $about->og_title = $request->og_title;
            $about->og_description = $request->og_description;
            $about->save();
        }

        if ($request->notification_update) {
            if($request->hasFile('noti_tune')){

                $validator = Validator::make($request->all(),[
                    'noti_tune'=>'required|mimes:mp3',
                ],[
                    "noti_tune.required"=>trans('messages.noti_tune_required'),
                    "noti_tune.mimes" => trans('messages.noti_tune_must_mp3'),
                ]);

                if ($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                else
                {
                    $noti_tune = 'notification.'. $request->noti_tune->getClientOriginalExtension();
                    //$request->noti_tune->move(env('ASSETSPATHURL').'admin-assets/notification', $noti_tune);
                    $about = About::first();
                        if(empty($about))
                        {
                            $about = new About();
                        }
                        else 
                        {
                            if($about->notification_tune != "" && file_exists(env('ASSETSPATHURL').'admin-assets/notification/'.$about->notification_tune)){
                            
                               $file = env('ASSETSPATHURL').'admin-assets/notification/'.$about->notification_tune;
                               unlink($file);
                             
                            }
                            $request->noti_tune->move(env('ASSETSPATHURL').'admin-assets/notification', $noti_tune); 
                        }
                    $about->notification_tune = $noti_tune;
                    $about->save();
               } 
            }
           
        }

        

        if ($request->theme_update)
        {
            $about = About::first();
            $about->theme = !empty($request->template) ? $request->template : 1;
            $about->save();
        }

        if ($request->business_update) {
            $validator = Validator::make($request->all(),[
                'max_order_qty'=>'required',
                'min_order_amount'=>'required',
                'max_order_amount'=>'required',
                'referral_amount'=>'required',
            ],[
                "max_order_qty.required"=>trans('messages.max_order_qty_required'),
                "min_order_amount.required"=>trans('messages.min_order_amount_required'),
                "max_order_amount.required"=>trans('messages.max_order_amount_required'),
                "referral_amount.required"=>trans('messages.referral_amount_required'),
            ]);
            if ($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }
                $about->currency = $request->currency;
                $about->currency_position = $request->currency_position;
                $about->referral_amount = $request->referral_amount;
                $about->max_order_qty = $request->max_order_qty;
                $about->min_order_amount = $request->min_order_amount;
                $about->max_order_amount = $request->max_order_amount;
                $about->maintenance_mode = isset($request->maintenance_mode) ? 1 : 2;
                $about->login_required = isset($request->login_required) ? 1 : 2;
                $about->pickup_delivery = $request->pickup_delivery;
                $about->save();
            }
        }
        if ($request->mobileapp_update) {
            if($request->hasFile('app_bottom_image')){
                $app_bottom_image = 'app_bottom_image-' . uniqid() . '.' . $request->app_bottom_image->getClientOriginalExtension();
                $request->app_bottom_image->move(env('ASSETSPATHURL').'admin-assets/images/about', $app_bottom_image);
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }else{
                    if($about->app_bottom_image != "" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->app_bottom_image)){
                        unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->app_bottom_image);
                    }
                }
                $about->app_bottom_image= $app_bottom_image;
                $about->save();
            }
            $about = About::first();
            if(empty($about)){
                $about = new About();
            }
            $about->android = $request->android;
            $about->ios = $request->ios;
            $about->save();
        }
        if ($request->about_update) {
            $about = About::first();
            if(empty($about)){
                $about = new About();
            }
            $about->about_content = $request->about_content;
            $about->save();
        }
        if ($request->web_update) {
            if($request->hasFile('mobile_app_bg_image')){
                $mobile_app_bg_image = 'mobile_app_bg_image-' . uniqid() . '.' . $request->mobile_app_bg_image->getClientOriginalExtension();
                $request->mobile_app_bg_image->move(env('ASSETSPATHURL').'admin-assets/images/about', $mobile_app_bg_image);
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }else{
                    if($about->mobile_app_bg_image != "" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->mobile_app_bg_image)){
                        unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->mobile_app_bg_image);
                    }
                }
                $about->mobile_app_bg_image= $mobile_app_bg_image;
                $about->save();
            }
            if($request->hasFile('mobile_app_image')){
                $mobile_app_image = 'mobile_app_image-' . uniqid() . '.' . $request->mobile_app_image->getClientOriginalExtension();
                $request->mobile_app_image->move(env('ASSETSPATHURL').'admin-assets/images/about', $mobile_app_image);
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }else{
                    if($about->mobile_app_image != "" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->mobile_app_image)){
                        unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->mobile_app_image);
                    }
                }
                $about->mobile_app_image= $mobile_app_image;
                $about->save();
            }
            if($request->hasFile('booknow_bg_image')){
                $booknow_bg_image = 'booknow_bg_image-' . uniqid() . '.' . $request->booknow_bg_image->getClientOriginalExtension();
                $request->booknow_bg_image->move(env('ASSETSPATHURL').'admin-assets/images/about', $booknow_bg_image);
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }else{
                    if($about->booknow_bg_image != "" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->booknow_bg_image)){
                        unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->booknow_bg_image);
                    }
                }
                $about->booknow_bg_image= $booknow_bg_image;
                $about->save();
            }
            if($request->hasFile('reviews_bg_image')){
                $reviews_bg_image = 'reviews_bg_image-' . uniqid() . '.' . $request->reviews_bg_image->getClientOriginalExtension();
                $request->reviews_bg_image->move(env('ASSETSPATHURL').'admin-assets/images/about', $reviews_bg_image);
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }else{
                    if($about->reviews_bg_image != "" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->reviews_bg_image)){
                        unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->reviews_bg_image);
                    }
                }
                $about->reviews_bg_image= $reviews_bg_image;
                $about->save();
            }
            if($request->hasFile('footer_bg_image')){
                $footer_bg_image = 'footer_bg_image-' . uniqid() . '.' . $request->footer_bg_image->getClientOriginalExtension();
                $request->footer_bg_image->move(env('ASSETSPATHURL').'admin-assets/images/about', $footer_bg_image);
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }else{
                    if($about->footer_bg_image != "" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->footer_bg_image)){
                        unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->footer_bg_image);
                    }
                }
                $about->footer_bg_image= $footer_bg_image;
                $about->save();
            }
            if($request->hasFile('auth_bg_image')){
                $auth_bg_image = 'auth_bg_image-' . uniqid() . '.' . $request->auth_bg_image->getClientOriginalExtension();
                $request->auth_bg_image->move(env('ASSETSPATHURL').'admin-assets/images/about', $auth_bg_image);
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }else{
                    if($about->auth_bg_image != "" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->auth_bg_image)){
                        unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->auth_bg_image);
                    }
                }
                $about->auth_bg_image= $auth_bg_image;
                $about->save();
            }
            if($request->hasFile('breadcrumb_bg_image')){
                $breadcrumb_bg_image = 'breadcrumb_bg_image-' . uniqid() . '.' . $request->breadcrumb_bg_image->getClientOriginalExtension();
                $request->breadcrumb_bg_image->move(env('ASSETSPATHURL').'admin-assets/images/about', $breadcrumb_bg_image);
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }else{
                    if($about->breadcrumb_bg_image != "" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->breadcrumb_bg_image)){
                        unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->breadcrumb_bg_image);
                    }
                }
                $about->breadcrumb_bg_image= $breadcrumb_bg_image;
                $about->save();
            }
            if($request->hasFile('footer_logo')){
                $footer_logo = 'footer-' . uniqid() . '.' . $request->footer_logo->getClientOriginalExtension();
                $request->footer_logo->move(env('ASSETSPATHURL').'admin-assets/images/about', $footer_logo);
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }else{
                    if($about->footer_logo != "" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->footer_logo)){
                        unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->footer_logo);
                    }
                }
                $about->footer_logo= $footer_logo;
                $about->save();
            }
            if($request->hasFile('favicon')){
                $favicon = 'favicon-' . uniqid() . '.' . $request->favicon->getClientOriginalExtension();
                $request->favicon->move(env('ASSETSPATHURL').'admin-assets/images/about', $favicon);
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }else{
                    if($about->favicon != "" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->favicon)){
                        unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->favicon);
                    }
                }
                $about->favicon= $favicon;
                $about->save();
            }
            if($request->hasFile('logo')){
                $logo = 'logo-' . uniqid() . '.' . $request->logo->getClientOriginalExtension();
                $request->logo->move(env('ASSETSPATHURL').'admin-assets/images/about', $logo);
                $about = About::first();
                if(empty($about)){
                    $about = new About();
                }else{
                    if($about->logo != "" && file_exists(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->logo)){
                        unlink(env('ASSETSPATHURL').'admin-assets/images/about/'.$about->logo);
                    }
                }
                $about->logo= $logo;
                $about->save();
            }
            if (!empty($request->feature_icon)) {
                foreach($request->feature_icon as $key => $icon){
                    if (!empty($icon) && !empty($request->feature_title[$key]) && !empty($request->feature_description[$key]) ) {
                        $feature = new FooterFeatures;
                        $feature->icon = $icon;
                        $feature->title = $request->feature_title[$key];
                        $feature->description = $request->feature_description[$key];
                        $feature->save();
                    }
                }
            }
            if (!empty($request->edit_icon_key)) {
                foreach($request->edit_icon_key as $key => $id){
                    $feature = FooterFeatures::find($id);
                    $feature->icon = $request->edi_feature_icon[$id];
                    $feature->title = $request->edi_feature_title[$id];
                    $feature->description = $request->edi_feature_description[$id];
                    $feature->save();
                }
            }
            $about = About::first();
            if(empty($about)){
                $about = new About();
            }
            $about->mobile_app_title = $request->mobile_app_title;
            $about->mobile_app_description = $request->mobile_app_description;
            $about->copyright = $request->copyright;
            $about->title = $request->title;
            $about->short_title = $request->short_title;
            $about->footer_title = $request->footer_title;
            $about->footer_description = $request->footer_description;
            $about->save();
        }
        return redirect('admin/settings')->with('success', trans('messages.success'));
    }
}