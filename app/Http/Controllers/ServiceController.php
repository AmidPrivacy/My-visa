<?php

namespace App\Http\Controllers;
use App\Models\Services; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index() 
    {

        $list = DB::select("select s.id, s.name, s.picture, s.content from services s where s.is_deleted=0 ORDER BY s.name");
 
        return view('admin.service.index')->with(["list" => $list]);

    }


    public function create(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $imageName = time().'.'.$request->image->extension();  
     
        $request->image->move(public_path('assets/uploads/service-images/'), $imageName);
        
        $new_service = new Services();
        $new_service->name = $request->name; 
        $new_service->content = $request->content;  
        $new_service->picture = $imageName;  
        $new_service->uuid = $this->gen_uuid();   
         
        if($new_service->save()) { 

            return back()->with('success','Məlumat əlavə edildi');

        } else {

            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');

        }

    }

    public function fetchById($id) {

        $service = Services::find($id);

        return response()->json([
            'data' => $service,
            'error' => null,
        ]);
 
    }

    public function update($id, Request $request) {

        $service = Services::find($id); 
        $service->name = $request->name; 
        $service->content = $request->content;  
        
        if($service->save()) { 
            return back()->with('success','Məlumat yeniləndi');
        } else { 
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

    public function updateImg($id, Request $request) {

        $service = Services::find($id); 

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();  
     
        $request->image->move(public_path('assets/uploads/service-images/'), $imageName);

        $oldPicture = $service->picture;

        $service->picture = $imageName; 

        if(unlink(public_path('assets/uploads/service-images/'.$oldPicture)))
            if($service->save()) { 
                
                return back()->with('success','Məlumat yeniləndi');
            } else { 
                return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
            }

    }

    public function delete($id) {

        $service = Services::find($id);

        $service->is_deleted = 1;

        if($service->save()) { 

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