<?php

namespace App\Http\Controllers;
use App\Models\VisaTypeDetails;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisaTypeDetailController extends Controller
{

    public function all() 
    {
        $list = DB::select("select id, name, picture from countries where status=1");
    
        return view('admin.all-countries')->with(["list" => $list]);
    }

    public function selectedCountry($id) 
    {
        
        $list = DB::select("select id, name, picture from countries where status=1");

        $selectedCountry = Countries::find($id);

        $types = DB::select("select id, name from visa_types where country_id = ?", [$id]);
    
        return view('admin.index')->with(["list" => $list, "selected" => $selectedCountry, "types"=>$types]);

    }

    public function index() 
    {
        $list = DB::select("select d.id, d.name, t.name as type from visa_type_details d inner join visa_types t on d.type_id = t.id where d.status=1");
        $types = DB::select("select t.id, t.name from visa_types t where t.status=1");
 
        return view('admin.faq.index')->with(["list" => $list, "types" => $types]);
    }

    public function create(Request $request)
    {
 
        $faq = new VisaTypeDetails();
        $faq->name = $request->name; 
        $faq->type_id = $request->type; 
        $faq->content = $request->content; 
        
        if($faq->save()) {
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

        $faq->name = $request->name; 
        $faq->type_id = $request->type; 
        $faq->content = $request->content; 

        if($faq->save()) {
            return back()->with('success','Məlumat yeniləndi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

    public function delete($id) {

        $faq = VisaTypeDetails::find($id);

        $faq->status = 0;

        if($faq->save()) {
            return back()->with('success','Məlumat silindi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

}