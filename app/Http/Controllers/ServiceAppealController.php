<?php

namespace App\Http\Controllers;  
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 
use App\Models\VisaServiceAppeals;
use Validator;

class ServiceAppealController extends Controller
{
      
    public function index()
    {
      
        $query = ""; 
        if(auth()->user()->role_id ===1) { 
            $query = " where a.user_id is null or user_id=".auth()->user()->id;
        }

        $list = DB::select("select a.id, a.note, a.user_id, st.name as step, s.name as service, a.full_name, a.mail, u.name as user,
            a.number, a.created_at as date from visa_service_appeals a inner join services s on a.service_id = s.id 
            inner join appeal_steps st on a.step_id = st.id left join users u on a.user_id=u.id ".$query." order by a.id desc");

        $steps = DB::select("select id, name from appeal_steps where status=1");
        $users = DB::select("select id, name from users where is_deleted=0");

        return view('admin.serviceAppeal.index')->with(["list" => $list, "steps" => $steps, "users" => $users]);

    }
 
    public function editStatus(Request $request) {

        $appeal = VisaServiceAppeals::find($request->id);

        $appeal->step_id = $request->step; 

        if($appeal->save()) {

            return back()->with('success','Məlumat yeniləndi');

        } else {

            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
            
        }
    }

    public function appointUser(Request $request) {

        $appeal = VisaServiceAppeals::find($request->id);

        $appeal->user_id = $request->user; 

        if($appeal->save()) {
 
            return back()->with('success','Məlumat yeniləndi');

        } else {

            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
            
        }
    }

}
