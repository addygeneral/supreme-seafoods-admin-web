<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zone;
use Illuminate\Support\Facades\Validator;
class ZoneController extends Controller
{
    public function index(Request $request)
    {
        $zonedata = Zone::get();
        return view('admin.zone.index',compact('zonedata'));  
    }

    
    public function add_zone()
    {
        return view('admin.zone.add');  
    }

   

    public function update_zone($id,Request $request)
    {
        $zonedata = Zone::where('id',$id)->first();
        if(empty($zonedata)){
            return view('admin.zone.add');
        }else{
            $data = str_replace(['(',')',' '],'',explode('),',$zonedata->coordinates));
            foreach($data as $value){
                $arr = explode(',',$value);
                $polygoncoords[] = array(
                    "lat"=>(float)$arr[0],
                    "lng"=>(float)$arr[1]
                );
            }
            $polygoncoords = json_encode($polygoncoords);
            return view('admin.zone.edit',compact('zonedata','polygoncoords'));
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'coordinates' => 'required',
            'delivery_charge' => 'required',
        ],[
            "name.required"=>trans('messages.zonename_required'),
            "coordinates.required"=>trans('messages.coordinates_required'),
            "delivery_charge.required"=>trans('messages.delivery_charge_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $zone = new Zone;
            $zone->name = $request->name;
            $zone->coordinates = $request->coordinates;
            $zone->delivery_charge = $request->delivery_charge;
            $zone->save();
            return redirect('admin/zone')->with('success',trans('messages.success'));
        }
    }



    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'coordinates' => 'required',
            'delivery_charge' => 'required',
        ],[
            "name.required"=>trans('messages.zonename_required'),
            "coordinates.required"=>trans('messages.coordinates_required'),
            "delivery_charge.required"=>trans('messages.delivery_charge_required'),
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $zone = Zone::find($request->id);
            $zone->name = $request->name;
            $zone->coordinates = $request->coordinates;
            $zone->delivery_charge = $request->delivery_charge;
            $zone->save();
            return redirect('admin/zone')->with('success',trans('messages.success'));
        }
    }

    public function delete_zone(Request $request)
    {
        $zone = Zone::where('id',$request->id)->delete();
        return 1;
    }
}
