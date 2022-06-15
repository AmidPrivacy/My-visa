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
        $appeal->number = $request->c_code.$request->number.$request->c_number;

        $users = DB::select("select id, name, status from users where is_deleted=0 and status=1");

        if(!empty($users)) {

            $randomIndex = rand(0, count($users)-1);
            // dd($randomIndex);
            $appeal->user_id = $users[$randomIndex]->id;
            $appeal->step_id = 1;
 
        } else {
            $appeal->step_id = 2;
        }
        // dd($request->appeal_types);
        if($appeal->save()) { 
            

            if(isset($request->appeal_types) && count($request->appeal_types)>0){
                $appealTypes = [];
                foreach ($request->appeal_types as $item)
                {     

                    array_push($appealTypes, [
                        'appeal_id' => $appeal->id,
                        'type_id' => $item
                    ]);

                }

                $inserted = DB::table('appeal_selected_types')->insert($appealTypes);
                if($inserted) {
                    return back()->with('success','Müraciət göndərildi!');
                } else {
                    return back()->with('error','Xəta baş verdi(müraciət tipləri!), zəhmət olmasa biraz sora yenidən cəhd edin');
                }
            }
            return back()->with('success','Müraciət göndərildi!');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        } 
        
    }

    public function index()
    {
        $list = DB::select("select a.id, a.name, a.surname, a.number, s.name as step, a.created_at as date, s.id as stepId from appeals a inner join appeal_steps s on a.step_id = s.id where a.status=1 and user_id=".auth()->user()->id);
        $steps = DB::select("select id, name from appeal_steps where status=1");
        $users = DB::select("select id, name from users where is_deleted=0");

        if(count($list)>0) {
            foreach($list as $item) {
                $item->types = DB::select("select t.name, t.path from appeal_selected_types a inner join appeal_types t on a.type_id=t.id where a.appeal_id=".$item->id);
            }
        } 

        return view('admin.appeal.index')->with(["list" => $list, "steps" => $steps, "users" => $users]);
    }

    public function search(Request $request) {

        $name = $request->name;
        $surName = $request->surName;
        $number = $request->number;
        $status = $request->status;
        $startDate = $request->startDate;
        $endDate = $request->endDate; 
        $currentDate = date('Y-m-d');

        $str = "";
        
        if(strlen($name)>0) {
            $str .= " and a.name LIKE '%".$name."%'";
        }

        if(strlen($surName)>0) {
            $str .= " and a.surname LIKE '%".$surName."%'";
        }

        if(strlen($number)>0) {
            $str .= " and a.number LIKE '%".$number."%'";
        }

        if(strlen($startDate)>0 && strlen($endDate)>0) {
            $str .= " and a.created_at BETWEEN '$startDate' AND '$endDate'"; 
        } elseif(strlen($startDate)>0) {
            $str .= " and a.created_at BETWEEN '$startDate' AND '$currentDate'";
        } elseif(strlen($endDate)>0) {
            $str .= " and a.created_at BETWEEN '$currentDate' AND '$endDate'";
        }

        if($status !=="0") {
            $str .= " and s.id = ".$status;
        }
 
        
        $list = DB::select("select a.id, a.name, a.surname, a.number, s.name as step, a.created_at as date, s.id as stepId from appeals a inner join appeal_steps s on a.step_id = s.id where a.status=1".$str." and user_id=".auth()->user()->id);

        if(count($list)>0) {
            foreach($list as $item) {
                $item->types = DB::select("select t.name, t.path from appeal_selected_types a inner join appeal_types t on a.type_id=t.id where a.appeal_id=".$item->id);
            }
        } 

        return response()->json([
            'data' => $list,
            'error' => null,
        ]);

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
