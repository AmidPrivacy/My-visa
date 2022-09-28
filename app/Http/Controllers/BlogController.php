<?php

namespace App\Http\Controllers;  
use App\Models\Blogs; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index() 
    {

        $list = DB::select("select * from blogs where is_deleted=0"); 
 
        return view('admin.blog.index')->with(["list" => $list]);

    }


    public function create(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $imageName = time().'.'.$request->image->extension();  
     
        $request->image->move(public_path('assets/uploads/blog-files/'), $imageName);
        
        $new_blog = new Blogs();
        $new_blog->title = $request->title; 
        $new_blog->content = $request->content;
        $new_blog->picture = $imageName;  
        
        if($new_blog->save()) { 

            return back()->with('success','Məlumat əlavə edildi');

        } else {

            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');

        }

    }

    public function fetchById($id) {

        $blog = Blogs::find($id);

        return response()->json([
            'data' => $blog,
            'error' => null,
        ]);
 
    }

    public function update($id, Request $request) {

        $blog = Blogs::find($id); 
        $blog->title = $request->title; 
        $blog->content = $request->content;
        
        if($blog->save()) { 
            return back()->with('success','Məlumat yeniləndi');
        } else { 
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

    public function delete($id) {

        $blog = Blogs::find($id);

        $blog->is_deleted = 1;

        if($blog->save()) { 
            return back()->with('success','Məlumat silindi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }  

}