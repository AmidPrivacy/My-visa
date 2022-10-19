<?php

namespace App\Http\Controllers;  
use App\Models\Blogs; 
use App\Models\MediaFiles;
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
        $new_blog->uuid = $this->gen_uuid();   
        
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

    public function updateImg($id, Request $request) {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();  

        $request->image->move(public_path('assets/uploads/blog-files/'), $imageName);

        if($request->fileType == "0") {

            $blog = Blogs::find($id); 
  
            $oldPicture = $blog->picture;
    
            $blog->picture = $imageName; 
    
            if(unlink(public_path('assets/uploads/blog-files/'.$oldPicture)))
                if($blog->save()) {  
                    return back()->with('success','Məlumat yeniləndi');
                } else { 
                    return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
                }
        } else {

            $media = new MediaFiles();

            $media->section_id = $id;
            $media->section_id = $id;
            $media->type = 2;
            $media->file = $imageName; 

            if($media->save()) {  
                return back()->with('success','Şəkil əlavə olundu');
            } else { 
                return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
            }
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