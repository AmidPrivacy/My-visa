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

    public function delete($id) {

        $service = Services::find($id);

        $service->is_deleted = 1;

        if($service->save()) { 

            return back()->with('success','Məlumat silindi');

        } else {

            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');

        }

    }


    

}