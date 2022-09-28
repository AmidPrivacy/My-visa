<?php

namespace App\Http\Controllers; 
use App\Models\Tours; 
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


    

}