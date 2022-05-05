<?php

namespace App\Http\Controllers;
use App\Models\filePaths;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{

    public function index() 
    {
        $list = DB::select("select id, name, file from file_paths where status=1");
 
        return view('admin.file.index')->with(["list" => $list]);
    }

    public function create(Request $request)
    {

        $request->validate([
            'file' => 'required|file|mimes:pdf,docx, doc',
        ]);
    
        $imageName = time().'.'.$request->file->extension();  
     
        $request->file->move(public_path('assets/uploads/files/'), $imageName);
        
        $new_file = new filePaths();
        $new_file->name = $request->name; 
        $new_file->file = $imageName; 
        
        if($new_file->save()) {
            return back()->with('success','Məlumat əlavə edildi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

    public function delete($id) {

        $file = filePaths::find($id);

        $file->status = 0;

        if($file->save()) {
            return back()->with('success','Məlumat silindi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

}