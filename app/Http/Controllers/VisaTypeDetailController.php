<?php

namespace App\Http\Controllers;
use App\Models\VisaTypeDetails;
use App\Http\Controllers\ArchiveController;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisaTypeDetailController extends Controller
{

    public function all() 
    {
        $list = DB::select("select id, name, picture from countries where status=1 ORDER BY name");
    
        return view('admin.all-countries')->with(["list" => $list]);
    }

    public function selectedCountry($id, Request $request) 
    {
        
        $list = DB::select("select id, name, picture from countries where status=1 ORDER BY name");

        $selectedCountry = Countries::find($id);

        $searchStay = (isset($request->period) && $request->period !=0) ? " and v.stay_period=".$request->period : "";

        $types = DB::select("select v.id, v.name, u.name as user from visa_types v left join users u on v.user_id=u.id where v.country_id = ? and v.status=1".$searchStay, [$id]);

        $all = [];

        foreach($types as $type) {
            $type->children = DB::select("select v_t.id, v_t.name, v_t.content, u.name as user from visa_type_details v_t left join users u on v_t.user_id=u.id where v_t.type_id = ? and v_t.status=1", [$type->id]);
            array_push($all, $type);
        }

        // dd($all);
    
        return view('admin.index')->with(["list" => $list, "selected" => $selectedCountry, "types"=>$all]);

    }

    public function index()
    {
        $list = DB::select("select d.id, d.name, t.name as type from visa_type_details d inner join visa_types t on d.type_id = t.id where d.status=1");
        $types = DB::select("select t.id, t.name, c.name as country from visa_types t inner join countries c on t.country_id = c.id where t.status=1");
        $files = DB::select("select id, name, file from file_paths where status=1");

        return view('admin.faq.index')->with(["list" => $list, "types" => $types, "files" => $files]);
    }

    public function create(Request $request)
    {
 
        $faq = new VisaTypeDetails();
        $faq->name = $request->title; 
        $faq->type_id = $request->type; 
        $faq->content = $request->content; 
        $faq->user_id = auth()->user()->id; 
        
        if($faq->save()) {
            (new ArchiveController())->create(3, $faq->id, 0);
            return back()->with('success','Məlumat əlavə edildi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

    public function fetchById($id) {

        $type = VisaTypeDetails::find($id);

        return response()->json([
            'data' => $type,
            'error' => null,
        ]);
 
    }

    public function update($id, Request $request) {

        $faq = VisaTypeDetails::find($id);

        $faq->name = $request->title; 
        $faq->type_id = $request->type; 
        $faq->content = $request->content; 

        if($faq->save()) {
            (new ArchiveController())->create(3, $id, 2);
            return back()->with('success','Məlumat yeniləndi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

    public function search(Request $request) {

        $title = $request->title;
        $type = $request->type;

        $str = "";
        
        if(strlen($title)>0) {
            $str .= " and d.name LIKE '%".$title."%'";
        }

        if($type !=="0") {
            $str .= " and t.id = ".$type;
        }
        // dd($str);
        $list = DB::select("select d.id, d.name, t.name as type from visa_type_details d inner join visa_types t on d.type_id = t.id where d.status=1".$str);

        return response()->json([
            'data' => $list,
            'error' => null,
        ]);

    }

    public function delete($id) {

        $faq = VisaTypeDetails::find($id);

        $faq->status = 0;

        if($faq->save()) {
            (new ArchiveController())->create(3, $id, 3);
            return back()->with('success','Məlumat silindi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

}