<?php

namespace App\Http\Controllers;
use App\Models\Appeals;
use App\Http\Controllers\ArchiveController;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 

class AppealController extends Controller
{
    
    function create(Request $request) {

        $appeal = new Appeals();
        $appeal->name = $request->name;
        $appeal->surname = $request->surname;
        $appeal->number = $request->number;

        if($appeal->save()) { 
            return back()->with('success','Müraciət göndərildi!');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        } 
        
    }

    public function index()
    {
        $list = DB::select("select a.id, a.name, a.surname, a.number, s.name as step from appeals a inner join appeal_steps s on a.step_id = s.id where a.status=1 and user_id=".auth()->user()->id);
        $steps = DB::select("select id, name from appeal_steps where status=1");
        $users = DB::select("select id, name from users where is_deleted=0");
        return view('admin.appeal.index')->with(["list" => $list, "steps" => $steps, "users" => $users]);
    }

    public function editStatus(Request $request) {

        $appeal = Appeals::find($request->id);

        $appeal->step_id = $request->step; 

        if($appeal->save()) {

            (new ArchiveController())->create(6, $appeal->id, 2);
            return back()->with('success','Məlumat yeniləndi');

        } else {

            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
            
        }
    }

    public function appointUser(Request $request) {

        $appeal = Appeals::find($request->id);

        $appeal->user_id = $request->user; 

        if($appeal->save()) {

            (new ArchiveController())->create(6, $appeal->id, 2);
            return back()->with('success','Məlumat yeniləndi');

        } else {

            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
            
        }
    }


}
