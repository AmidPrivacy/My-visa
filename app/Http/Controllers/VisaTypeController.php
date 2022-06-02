<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ArchiveController;
use App\Models\VisaTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisaTypeController extends Controller
{

    public function index() 
    {
        
        $countries = DB::select("select id, name, picture from countries where status=1");
        
        $list = [];

        foreach($countries as $country) {
            $types = DB::select("select id, name from visa_types where status=1 and country_id=?",[$country->id]);
            if(count($types)>0) {
                array_push($list, ["country"=>$country, "types"=>$types]);
            }
        }

        return view('admin.type.index')->with(["list" => $list, "countries" => $countries]);
    }

    public function create(Request $request)
    { 
        
        try {
            foreach ($request->name as $key => $value) {
                $ids[] = VisaTypes::insertGetId(
                    ['name' => $value, 'stay_period' => $request->stay_period[$key], 'country_id' => $request->country_id, "user_id" => auth()->user()->id]
                );
            }

            if(count($request->name) === count($ids)){

                foreach($ids as $id) {
                    (new ArchiveController())->create(2, $id, 0);
                }

                return back()->with('success','Məlumat əlavə edildi');

            } else {
                return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
            }
        } catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        } 

    }

    public function search($name) {
    
        // $list = DB::select("select t.id, t.name, c.name as country from visa_types t inner join countries c on t.country_id = c.id WHERE t.name LIKE '%".$name."%' AND t.status = 1");
        $countries = DB::select("select id, name, picture from countries where status=1");

        $list = [];

        foreach($countries as $country) {
            $types = DB::select("select id, name from visa_types where status=1 and name LIKE '%".$name."%' and country_id=?",[$country->id]);
            if(count($types)>0) {
                array_push($list, ["country"=>$country, "types"=>$types]);
            } 
        }

        // dd($list);

        return response()->json([
            'data' => $list,
            'error' => null,
        ]);

    }

    public function delete($id) {

        $type = VisaTypes::find($id);

        $type->status = 0;

        if($type->save()) {
            (new ArchiveController())->create(2, $type->id, 3);
            return back()->with('success','Məlumat silindi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

}