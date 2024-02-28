<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blogs;
use App\Models\Gallery;
use App\Models\Team;
use App\Models\Faq;
use App\Models\Tutorial;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class OtherPagesController extends Controller
{
    // blogs
    public function blogs_index(Request $request){
        $getblogs = Blogs::orderBydesc('id')->get();
        return view('admin.blogs.index',compact('getblogs'));
    }
    public function blogs_add(Request $request){
        return view('admin.blogs.add');
    }
    public function blogs_store(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ],[
            "title.required"=>trans('messages.title_required'),
            "description.required"=>trans('messages.description_required'),
            "image.required"=>trans('messages.image_required'),
            "image.image"=>trans('messages.enter_image_file'),
            "image.mimes"=>trans('messages.valid_image'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $image = 'blog-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(env('ASSETSPATHURL').'admin-assets/images/about', $image);
            $blog = new Blogs;
            $blog->image = $image;
            $blog->title = $request->title;
            $blog->slug = $this->getblogslug($request->title,'');
            $blog->description = $request->description;
            $blog->save();
            return redirect('admin/blogs')->with('success', trans('messages.success'));
        }
    }
    public function blogs_show(Request $request){
        $blogdata = Blogs::find($request->id);
        return view('admin.blogs.edit',compact('blogdata'));
    }
    public function blogs_update(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
        ],[
            "title.required"=>trans('messages.title_required'),
            "description.required"=>trans('messages.description_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $blog = Blogs::find($request->id);
            if($request->file('image') != ""){
                $validator = Validator::make($request->all(),
                ['image' => 'required|image|mimes:jpeg,png,jpg',],
                ["image.required"=>trans('messages.image_required'),
                "image.image"=>trans('messages.enter_image_file'),
                "image.mimes"=>trans('messages.valid_image'),]);
                if ($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    if(file_exists(storage_path()."/app/public/admin-assets/images/about/".$blog->image)){
                        unlink(storage_path()."/app/public/admin-assets/images/about/".$blog->image);
                    }
                    $image = 'blog-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
                    $request->image->move(env('ASSETSPATHURL').'admin-assets/images/about', $image);
                    $blog->image = $image;
                    $blog->save();
                }
            }
            $blog->title = $request->title;
            $blog->slug = $this->getblogslug($request->title,$request->id);
            $blog->description = $request->description;
            $blog->save();
            return redirect('admin/blogs')->with('success', trans('messages.success'));
        }
    }
    public function blogs_delete(Request $request){
        $blog = Blogs::find($request->id);
        if(file_exists(storage_path()."/app/public/admin-assets/images/about/".$blog->image)){
            unlink(storage_path()."/app/public/admin-assets/images/about/".$blog->image);
        }
        if ($blog->delete()) {
            return 1;
        } else {
            return 0;
        }
    }
    public function getblogslug($title, $id)
    {
        $slug = Str::slug($title,'-');
        $checkslug = Blogs::where('slug',$slug);
        if($id != ""){
            $checkslug = $checkslug->where('id','!=',$id);
        }
        $checkslug = $checkslug->first();
        if(!empty($checkslug)){
            $slug .= '-'.Blogs::select('id')->orderByDesc('id')->first()->id;
        }
        return $slug;
    }
    // OUR-TEAM
    public function our_team_index(Request $request){
        $getteams = Team::orderBydesc('id')->get();
        return view('admin.team.index',compact('getteams'));
    }
    public function our_team_add(Request $request){
        return view('admin.team.add');
    }
    public function our_team_store(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
            'fb' => 'required',
            'youtube' => 'required',
            'insta' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ],[
            "title.required"=>trans('messages.title_required'),
            "subtitle.required"=>trans('messages.subtitle_required'),
            "description.required"=>trans('messages.description_required'),
            "fb.required"=>trans('messages.link_required'),
            "youtube.required"=>trans('messages.link_required'),
            "insta.required"=>trans('messages.link_required'),
            "image.required"=>trans('messages.image_required'),
            "image.image"=>trans('messages.enter_image_file'),
            "image.mimes"=>trans('messages.valid_image'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $image = 'team-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(env('ASSETSPATHURL').'admin-assets/images/about', $image);
            $team = new Team;
            $team->image = $image;
            $team->title = $request->title;
            $team->subtitle = $request->subtitle;
            $team->fb = $request->fb;
            $team->youtube = $request->youtube;
            $team->insta = $request->insta;
            $team->description = $request->description;
            $team->save();
            return redirect('admin/our-team')->with('success', trans('messages.success'));
        }
    }
    public function our_team_show(Request $request){
        $teamdata = Team::find($request->id);
        return view('admin.team.edit',compact('teamdata'));
    }
    public function our_team_update(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
            'fb' => 'required',
            'youtube' => 'required',
            'insta' => 'required',
        ],[
            "title.required"=>trans('messages.title_required'),
            "subtitle.required"=>trans('messages.subtitle_required'),
            "description.required"=>trans('messages.description_required'),
            "fb.required"=>trans('messages.link_required'),
            "youtube.required"=>trans('messages.link_required'),
            "insta.required"=>trans('messages.link_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $team = Team::find($request->id);
            if($request->file('image') != ""){
                $validator = Validator::make($request->all(),
                ['image' => 'required|image|mimes:jpeg,png,jpg',],
                ["image.required"=>trans('messages.image_required'),
                "image.image"=>trans('messages.enter_image_file'),
                "image.mimes"=>trans('messages.valid_image'),]);
                if ($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    if(file_exists(storage_path()."/app/public/admin-assets/images/about/".$team->image)){
                        unlink(storage_path()."/app/public/admin-assets/images/about/".$team->image);
                    }
                    $image = 'team-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
                    $request->image->move(env('ASSETSPATHURL').'admin-assets/images/about', $image);
                    $team->image = $image;
                    $team->save();
                }
            }
            $team->title = $request->title;
            $team->subtitle = $request->subtitle;
            $team->fb = $request->fb;
            $team->youtube = $request->youtube;
            $team->insta = $request->insta;
            $team->description = $request->description;
            $team->save();
            return redirect('admin/our-team')->with('success', trans('messages.success'));
        }
    }
    public function our_team_delete(Request $request){
        $team = Team::find($request->id);
        if(file_exists(storage_path()."/app/public/admin-assets/images/about/".$team->image)){
            unlink(storage_path()."/app/public/admin-assets/images/about/".$team->image);
        }
        if ($team->delete()) {
            return 1;
        } else {
            return 0;
        }
    }
    // tutorial
    public function tutorial_index(Request $request){
        $gettutorials = Tutorial::orderBydesc('id')->get();
        return view('admin.tutorial.index',compact('gettutorials'));
    }
    public function tutorial_add(Request $request){
        return view('admin.tutorial.add');
    }
    public function tutorial_store(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ],[
            "title.required"=>trans('messages.title_required'),
            "description.required"=>trans('messages.description_required'),
            "image.required"=>trans('messages.image_required'),
            "image.image"=>trans('messages.enter_image_file'),
            "image.mimes"=>trans('messages.valid_image'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $image = 'tutorial-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(env('ASSETSPATHURL').'admin-assets/images/about', $image);
            $team = new Tutorial;
            $team->image = $image;
            $team->title = $request->title;
            $team->description = $request->description;
            $team->save();
            return redirect('admin/tutorial')->with('success', trans('messages.success'));
        }
    }
    public function tutorial_show(Request $request){
        $tutorialdata = Tutorial::find($request->id);
        return view('admin.tutorial.edit',compact('tutorialdata'));
    }
    public function tutorial_update(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
        ],[
            "title.required"=>trans('messages.title_required'),
            "description.required"=>trans('messages.description_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $team = Tutorial::find($request->id);
            if($request->file('image') != ""){
                $validator = Validator::make($request->all(),
                ['image' => 'required|image|mimes:jpeg,png,jpg',],
                ["image.required"=>trans('messages.image_required'),
                "image.image"=>trans('messages.enter_image_file'),
                "image.mimes"=>trans('messages.valid_image'),]);
                if ($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    if(file_exists(storage_path()."/app/public/admin-assets/images/about/".$team->image)){
                        unlink(storage_path()."/app/public/admin-assets/images/about/".$team->image);
                    }
                    $image = 'tutorial-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
                    $request->image->move(env('ASSETSPATHURL').'admin-assets/images/about', $image);
                    $team->image = $image;
                    $team->save();
                }
            }
            $team->title = $request->title;
            $team->description = $request->description;
            $team->save();
            return redirect('admin/tutorial')->with('success', trans('messages.success'));
        }
    }
    public function tutorial_delete(Request $request){
        $team = Tutorial::find($request->id);
        if(file_exists(storage_path()."/app/public/admin-assets/images/about/".$team->image)){
            unlink(storage_path()."/app/public/admin-assets/images/about/".$team->image);
        }
        if ($team->delete()) {
            return 1;
        } else {
            return 0;
        }
    }
    // faq
    public function faq_index(Request $request){
        $getfaqs = Faq::orderBydesc('id')->get();
        return view('admin.faq.index',compact('getfaqs'));
    }
    public function faq_add(Request $request){
        return view('admin.faq.add');
    }
    public function faq_store(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
        ],[
            "title.required"=>trans('messages.title_required'),
            "description.required"=>trans('messages.description_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $team = new Faq;
            $team->title = $request->title;
            $team->description = $request->description;
            $team->save();
            return redirect('admin/faq')->with('success', trans('messages.success'));
        }
    }
    public function faq_show(Request $request){
        $faqdata = Faq::find($request->id);
        return view('admin.faq.edit',compact('faqdata'));
    }
    public function faq_update(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
        ],[
            "title.required"=>trans('messages.title_required'),
            "description.required"=>trans('messages.description_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $faq = Faq::find($request->id);
            $faq->title = $request->title;
            $faq->description = $request->description;
            $faq->save();
            return redirect('admin/faq')->with('success', trans('messages.success'));
        }
    }
    public function faq_delete(Request $request){
        $faq = Faq::find($request->id);
        if ($faq->delete()) {
            return 1;
        } else {
            return 0;
        }
    }
    // gallery
    public function gallery_index(Request $request){
        $getgalleries = Gallery::orderBydesc('id')->get();
        return view('admin.gallery.index',compact('getgalleries'));
    }
    public function gallery_add(Request $request){
        return view('admin.gallery.add');
    }
    public function gallery_store(Request $request){
        $validator = Validator::make($request->all(),[
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg',
        ],[
            "image.required"=>trans('messages.image_required'),
            "image.image"=>trans('messages.enter_image_file'),
            "image.*.image"=>trans('messages.enter_image_file'),
            "image.mimes"=>trans('messages.valid_image'),
            "image.*.mimes"=>trans('messages.valid_image'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            foreach($request->image as $img){
                $image = 'gallery-' . uniqid() . '.' . $img->getClientOriginalExtension();
                $img->move(env('ASSETSPATHURL').'admin-assets/images/about', $image);
                $team = new Gallery;
                $team->image = $image;
                $team->save();
            }
            return redirect('admin/gallery')->with('success', trans('messages.success'));
        }
    }
    public function gallery_show(Request $request){
        $gallerydata = Gallery::find($request->id);
        return view('admin.gallery.edit',compact('gallerydata'));
    }
    public function gallery_update(Request $request){
        $validator = Validator::make($request->all(),
        ['image' => 'required|image|mimes:jpeg,png,jpg',],
        ["image.required"=>trans('messages.image_required'),
        "image.image"=>trans('messages.enter_image_file'),
        "image.mimes"=>trans('messages.valid_image'),]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $gallery = Gallery::find($request->id);
            if(file_exists(storage_path()."/app/public/admin-assets/images/about/".$gallery->image)){
                unlink(storage_path()."/app/public/admin-assets/images/about/".$gallery->image);
            }
            $image = 'gallery-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(env('ASSETSPATHURL').'admin-assets/images/about', $image);
            $gallery->image = $image;
            $gallery->save();
            return redirect('admin/gallery')->with('success', trans('messages.success'));
        }
    }
    public function gallery_delete(Request $request){
        $gallery = Gallery::find($request->id);
        if(file_exists(storage_path()."/app/public/admin-assets/images/about/".$gallery->image)){
            unlink(storage_path()."/app/public/admin-assets/images/about/".$gallery->image);
        }
        if ($gallery->delete()) {
            return 1;
        } else {
            return 0;
        }
    }
}