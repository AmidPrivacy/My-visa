<?php

namespace App\Http\Controllers; 
use App\Models\Tours; 
use App\Models\MediaFiles; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    public function index() 
    {

        $list = DB::select("select * from tours where is_deleted=0"); 
 
        return view('admin.tour.index')->with(["list" => $list]);

    }


    public function create(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $imageName = time().'.'.$request->image->extension();  
     
        $request->image->move(public_path('assets/uploads/tour-images/'), $imageName);
        
        $new_tour = new Tours();
        $new_tour->title = $request->title; 
        $new_tour->content = $request->content; 
        $new_tour->price = $request->price; 
        $new_tour->period = $request->period; 
        $new_tour->uuid = $this->gen_uuid();
        
        $new_tour->picture = $imageName;  
        

        if($new_tour->save()) { 

            return back()->with('success','Məlumat əlavə edildi');

        } else {

            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');

        }

    }

    public function fetchById($id) {

        $tour = Tours::find($id);

        return response()->json([
            'data' => $tour,
            'error' => null,
        ]);
 
    }

    public function updateImg($id, Request $request) {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();  

        $request->image->move(public_path('assets/uploads/tour-images/'), $imageName);

        if($request->fileType == "0") {

            $tour = Tours::find($id); 
  
            $oldPicture = $tour->picture;
    
            $tour->picture = $imageName; 
    
            if(unlink(public_path('assets/uploads/tour-images/'.$oldPicture)))
                if($tour->save()) {  
                    return back()->with('success','Məlumat yeniləndi');
                } else { 
                    return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
                }
        } else {

            $media = new MediaFiles();

            $media->section_id = $id;
            $media->section_id = $id;
            $media->type = 1;
            $media->file = $imageName; 

            if($media->save()) {  
                return back()->with('success','Şəkil əlavə olundu');
            } else { 
                return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
            }
        }
        

    }

    public function update($id, Request $request) {

        $tour = Tours::find($id); 
        $tour->title = $request->title; 
        $tour->content = $request->content; 
        $tour->price = $request->price; 
        $tour->period = $request->period; 
        
        if($tour->save()) { 
            return back()->with('success','Məlumat yeniləndi');
        } else { 
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }
 

    public function delete($id) {

        $tour = Tours::find($id);

        $tour->is_deleted = 1;

        if($tour->save()) { 
            return back()->with('success','Məlumat silindi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
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