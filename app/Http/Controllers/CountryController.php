<?php

namespace App\Http\Controllers;
use App\Models\Countries;
use App\Http\Controllers\ArchiveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    public function index() 
    {
        $list = DB::select("select id, name, picture from countries where status=1");
 
        return view('admin.country.index')->with(["list" => $list]);
    }


    public function create(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $imageName = time().'.'.$request->image->extension();  
     
        $request->image->move(public_path('assets/uploads/flags/'), $imageName);
        
        $new_country = new Countries();
        $new_country->name = $request->name; 
        $new_country->user_id = auth()->user()->id;
        $new_country->picture = $imageName; 

        if($new_country->save()) {

            (new ArchiveController())->create(1, $new_country->id, 0);

            return back()->with('success','Məlumat əlavə edildi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

    public function delete($id) {

        $country = Countries::find($id);

        $country->status = 0;

        if($country->save()) {
            (new ArchiveController())->create(1, $id, 3);
            return back()->with('success','Məlumat silindi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }


    

}