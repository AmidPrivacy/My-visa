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
        $list = DB::select("select t.id, t.name, c.name as country from visa_types t inner join countries c on t.country_id = c.id where t.status=1");
 
        return view('admin.type.index')->with(["list" => $list, "countries" => $countries]);
    }

    public function create(Request $request)
    {
 
        $new_type = new VisaTypes();
        $new_type->name = $request->name; 
        $new_type->country_id = $request->country_id; 
        $new_type->user_id = auth()->user()->id; 
        
        if($new_type->save()) {
            (new ArchiveController())->create(2, $new_type->id, 0);
            return back()->with('success','Məlumat əlavə edildi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

    public function delete($id) {

        $type = VisaTypes::find($id);

        $type->status = 0;

        if($type->save()) {
            (new ArchiveController())->create(2, $faq->id, 3);
            return back()->with('success','Məlumat silindi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

}