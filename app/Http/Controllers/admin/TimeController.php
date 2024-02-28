<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Time;
use Illuminate\Support\Facades\Validator;

class TimeController extends Controller
{
    public function index()
    {
        $gettime = Time::all();
        return view('admin.time', compact('gettime'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'open_time.*' => 'required',
            'break_start.*' => 'required',
            'break_end.*' => 'required',
            'close_time.*' => 'required',
            'always_close.*' => 'required',
        ], [
                "open_time.*.required" => trans('messages.select_time'),
                "break_start.*.required" => trans('messages.select_time'),
                "break_end.*.required" => trans('messages.select_time'),
                "close_time.*.required" => trans('messages.select_time'),
                "always_close.*.required" => trans('messages.select'),
            ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $day = $request->day;
            $open_time = $request->open_time;
            $break_start = $request->break_start;
            $break_end = $request->break_end;
            $close_time = $request->close_time;
            $always_close = $request->always_close;
            foreach ($day as $key => $no) {
                $input['day'] = $no;
                if ($always_close[$key] == "2") {
                    if (strtolower($close_time[$key]) == "closed") {
                        $input['open_time'] = "12:00am";
                        $input['break_start'] = "12:00pm";
                        $input['break_end'] = "01:00pm";
                        $input['close_time'] = "11:30pm";
                    } else {
                        $input['open_time'] = $open_time[$key];
                        $input['break_start'] = $break_start[$key];
                        $input['break_end'] = $break_end[$key];
                        $input['close_time'] = $close_time[$key];
                    }
                } else {
                    $input['open_time'] = "12:00am";
                    $input['break_start'] = "12:00pm";
                    $input['break_end'] = "01:00pm";
                    $input['close_time'] = "11:30pm";
                }
                $input['always_close'] = $always_close[$key];
                Time::where('day', $no)->update($input);
            }
            return redirect()->back()->with('success_message', trans('messages.success'));
        }
    }
}