<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ratting;
class RattingController extends Controller
{
    public function index(){
        $getreview = Ratting::with('user_info')->orderBydesc('id')->paginate(12);
        return view('admin.reviews.reviews',compact('getreview'));
    }
    public function destroy(Request $request){
        $review = Ratting::where('id', $request->id)->delete();
        if ($review) {
            return 1;
        } else {
            return 0;
        }
    }
}
