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

        $list = DB::select("select c.id, c.name, c.picture, v.name as color, v.type as type, c.price from countries c left join visa_colors v on c.visa_color_id = v.id where c.status=1 ORDER BY c.name");
        $colors = DB::select("select id, name, type from visa_colors where status=1");
 
        // $this->updateUuid($list);

        return view('admin.country.index')->with(["list" => $list, "colors" => $colors]);

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
        $new_country->price = $request->price; 
        $new_country->uuid = $this->gen_uuid(); 
        $new_country->user_id = auth()->user()->id;
        $new_country->picture = $imageName; 
        $new_country->visa_color_id = isset($request->color)?$request->color:0; 
 
        if($new_country->save()) {

            (new ArchiveController())->create(1, $new_country->id, 0);

            return back()->with('success','Məlumat əlavə edildi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

    public function fetchById($id) {

        $countries = Countries::find($id);

        return response()->json([
            'data' => $countries,
            'error' => null,
        ]);
 
    }

    public function update($id, Request $request) {

        $country = Countries::find($id); 
        $country->name = $request->name; 
        $country->visa_color_id = $request->color;  
        $country->price = $request->price;  
        
        if($country->save()) { 
            return back()->with('success','Məlumat yeniləndi');
        } else { 
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

    public function search(Request $request) {

        $query = "";
        if(strlen($request->name)>0) {
            $query .=  " and c.name LIKE '%".$request->name."%'";
        }

        if($request->color != 0) {
            $query .= " and c.visa_color_id = ".$request->color;
        }
        // dd($query);
        $list = DB::select("select c.id, c.name, c.picture, v.name as color, v.type as type FROM `countries` c left join visa_colors v on c.visa_color_id = v.id WHERE c.status = 1".$query);
    
        return response()->json([
            'data' => $list,
            'error' => null,
        ]);

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

    public function updateUuid($list)
    {
        foreach($list as $item) {
            $new_country = Countries::find($item->id);
            $new_country->uuid = $this->gen_uuid(); 
            $new_country->save();
        } 
    }

    public function gen_uuid() {
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

			// 16 bits for "time_mid"
			mt_rand( 0, 0xffff ),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand( 0, 0x0fff ) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand( 0, 0x3fff ) | 0x8000,

			// 48 bits for "node"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
		);
	}
    

}