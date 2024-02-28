<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Models\Notification;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class NotificationController extends Controller
{
    public function index(){
        $getnotification = Notification::with('category_info','item_info')->orderbyDesc('id')->get();
        return view('admin.notification.notification',compact('getnotification'));
    }
    public function add(){
        $getitem = Item::where('item_status','1')->where('is_deleted','2')->orderByDesc('id')->get();
        $getcategory = Category::where('is_available','1')->where('is_deleted','2')->orderByDesc('id')->get();
        return view('admin.notification.add',compact('getitem','getcategory'));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title'=> 'required',
            'message'=> 'required',
            'cat_id'=> 'required_if:type,==,1',
            'item_id'=> 'required_if:type,==,2',
        ],[
            "title.required"=>trans('messages.title_required'),
            "message.required"=>trans('messages.message_required'),
            "cat_id.required_if"=>trans('messages.category_required'),
            "item_id.required_if"=>trans('messages.item_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $notification = new Notification;
            $notification->title = $request->title;
            $notification->message = $request->message;
            $notification->cat_id = $request->cat_id;
            $notification->item_id = $request->item_id;
            $notification->save();
            $getallusers=User::select('token')->where('type','2')->where('is_available','1')->where('is_notification','1')->get();

            $type = "promotion";
            $sub_type = "";
            if($request->has('cat_id') && $request->cat_id != ""){
                $catdata = Category::find($request->cat_id);
                $category_id = $request->cat_id;
                $category_name = $catdata->category_name;
                $sub_type = "category";
            }else{
                $category_id = "";
                $category_name = "";
            }
            if($request->has('item_id') && $request->item_id != ""){
                $item_id = $request->item_id;
                $sub_type = "item";
            }else{
                $item_id = "";
            }
            $customdata = array(
                'type'=> $type,
                'sub_type'=> $sub_type,
                'category_id'=> $category_id,
                'category_name'=> $category_name,
                'item_id'=> $item_id,
                'order_id'=> "",
            );
            foreach ($getallusers as $checkuser) {
                $msg = array(
                    'body'=>$request->message,
                    'title'=>$request->title,
                    'sound'=>1/*Default sound*/
                );
                $fields = array(
                    'to'=> $checkuser->token,
                    'notification'=> $msg,
                    'data'=> $customdata
                );
                $headers = array(
                    'Authorization: key=' . helper::appdata()->firebase,
                    'Content-Type: application/json'
                );
                #Send Reponse To FireBase Server
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                $result = curl_exec ( $ch );
                curl_close ( $ch );
            }
            return redirect('admin/notification')->with('success', trans('messages.success'));
        }
    }
}
