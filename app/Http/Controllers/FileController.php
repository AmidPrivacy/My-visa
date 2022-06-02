<?php

namespace App\Http\Controllers;
use App\Models\filePaths;
use App\Models\Excell_paths;
use Illuminate\Http\Request;
use App\Http\Controllers\ArchiveController;
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
        $new_file->user_id = auth()->user()->id;
        
        if($new_file->save()) {

            (new ArchiveController())->create(4, $new_file->id, 0);
            if($request->check_place==1){
                return back()->with('success','Məlumat əlavə edildi');
            } else {
                return response()->json([
                    'data' => $new_file,
                    'error' => null,
                ]);
            }
        } else {
            if($request->check_place==1){
                return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
            } else {
                return response()->json([
                    'data' => null,
                    'error' => "Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin",
                ]);
            }
        }

    }

    public function search($name) {
    
        $list = DB::select("select id, name, file from file_paths WHERE name LIKE '%".$name."%' AND status = 1");
    
        return response()->json([
            'data' => $list,
            'error' => null,
        ]);

    }

    public function delete($id) {

        $file = filePaths::find($id);

        $file->status = 0;

        if($file->save()) {
            (new ArchiveController())->create(4, $id, 3);
            return back()->with('success','Məlumat silindi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

    // excell methods
    public function excellList() 
    {
        $list = DB::select("select id, name, file from excell_paths where status=1");
 
        return view('admin.excell.index')->with(["list" => $list]);
    }

    public function excellCreate(Request $request)
    {

        $request->validate([
            'file' => 'required|file',
        ]);
    
        $imageName = time().'.'.$request->file->extension();  
     
        $request->file->move(public_path('assets/uploads/excell/'), $imageName);
        
        $new_file = new Excell_paths();
        $new_file->name = $request->name; 
        $new_file->file = $imageName; 
        $new_file->user_id = auth()->user()->id;
        
        if($new_file->save()) {

            (new ArchiveController())->create(5, $new_file->id, 0);
           
            return back()->with('success','Məlumat əlavə edildi');
            
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

    public function excellDelete($id) {

        $file = Excell_paths::find($id);

        $file->status = 0;

        if($file->save()) {
            (new ArchiveController())->create(4, $id, 3);
            return back()->with('success','Məlumat silindi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

}