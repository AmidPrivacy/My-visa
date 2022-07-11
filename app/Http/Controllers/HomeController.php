<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\visaCalls;
use App\Models\UserAppealRoles;
use App\Models\UserAppeals;

class HomeController extends Controller
{
    public function index() 
    {
        $types = DB::select("select id, name, path from appeal_types where is_deleted=0");
        return view('home.index')->with(["types"=>$types]);
    }

    // public function setStatus(Request $request) {

    //     $user = User::find($request->id); 
    //     $user->status = $request->status; 

    //     if($user->save()) {
    //         return response()->json([
    //             'data' => null,
    //             'error' => null,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'data' => null,
    //             'error' => "Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin",
    //         ]);
    //     }

    // }

    public function crm() { 

        $calls = DB::select("select v_c.id as id, v_c.citizen_number, u.name, v.name as type, 
            v_c.citizen_number, v_c.note, c.name as country, v_c.created_at from visa_calls v_c 
            left join countries c on v_c.country_id = c.id left join visa_types v on  
            v_c.visa_type_id=v.id left join users u on v_c.operator_number=u.internal_number where v_c.is_deleted=0");

        $countries = DB::select("select c.id, c.name from countries c where c.status=1 ORDER BY c.name");
        // dd($calls);
        return view('admin.crm.index')->with(["countries"=>$countries, "calls"=>$calls]);

    }

    public function setCall(Request $request) {

        $call = new visaCalls();

        $call->citizen_number = $request->citizenNumber;
        $call->operator_number = $request->internalNumber; 

        if($call->save()) {
            return response()->json([
                'data' => ["status"=>200, "message"=>"Uğurlu əməliyyat"],
                'error' => null,
            ]);
        } else {
            return response()->json([
                'data' => null,
                'error' => ["status"=>500, "message"=>"Sistem xətası, zəhmət olmasa yenidən cəhd edin"],
            ]);
        }

    }

    public function setStatus(Request $request) {

        // dd($request->status);
        if(isset($request->status) && $request->status !=="0"){
            $roles = DB::select("select appeal_type_id as type from user_appeal_roles where user_id=".$request->id);

            $appeals = [];

            if(count($roles)>0) {
    
                foreach ($roles as $key => $role) {
                $newAppeals = DB::select("select id from user_appeals where type_id=? and user_id IS NULL and is_deleted=0 order by id desc limit 4",[$role->type]);
    
                if(count($newAppeals)>0) {
                        $appeals = array_merge($appeals, $newAppeals);
                    }
                }
            } else {
                $generalAppeals = DB::select("select id from user_appeals where type_id IS NULL and user_id IS NULL and is_deleted=0 order by id desc limit 4");
                if(count($generalAppeals)>0) {
                    $appeals = array_merge($appeals, $generalAppeals);
                }
            }
    
            if(count($appeals)>0) {
                $ids = array_column($appeals, 'id');
                UserAppeals::whereIn('id', $ids)->update(['user_id' => $request->id]);
            }
            
        }
       
        $user = User::find($request->id); 
        $user->status = $request->status; 

        if($user->save()) {
            return response()->json([
                'data' => null,
                'error' => null,
            ]);
        } else {
            return response()->json([
                'data' => null,
                'error' => "Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin",
            ]);
        }

    }

    public function users() {
        $list = DB::select("select u.name, u.id, r.name as role from users u inner join user_roles r on u.role_id = r.id where u.is_deleted=0");
        $adminRoles= DB::select("select id, name from user_roles where is_deleted=0");
        $appealTypes= DB::select("select id, name from appeal_types where is_deleted=0");

        if(count($list)>0) {
            foreach($list as $item) {
                $item->types = DB::select("select u.id, t.name, t.path from user_appeal_roles u inner join appeal_types t on u.appeal_type_id=t.id where u.user_id=".$item->id);
            }
        }
        // dd($list);
        return view('admin.user.index')->with(["list" => $list, "adminRoles"=>$adminRoles, "appealTypes"=>$appealTypes]);
    }

    public function editAdminRole(Request $request) {

        $user = User::find($request->id);

        $user->role_id = $request->admin_role; 

        if($user->save()) {
 
            return back()->with('success','Məlumat yeniləndi');

        } else {

            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
            
        }
    }

    public function editAppealRole(Request $request) {

        $old = DB::select("select id path from user_appeal_roles where user_id=? and appeal_type_id=?", [$request->id, $request->appeal_role]);

        if(count($old)===0) {
            $appealRole = new UserAppealRoles();
            
            $appealRole->user_id = $request->id; 
            $appealRole->appeal_type_id = $request->appeal_role; 

            if($appealRole->save()) {
    
                return back()->with('success','Məlumat yeniləndi');

            } else {

                return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
                
            }
        } else {
            return back()->with('error','Bu müraciət rolu əlavə olunub, zəhmət olmasa biraz sora yenidən cəhd edin');
        }
    }

    public function deleteAppealRole($id) {

        $user = UserAppealRoles::find($id);
  
        if($user->delete()) { 
            return back()->with('success','Məlumat silindi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

    public function deleteUser($id) {

        $user = User::find($id);

        $user->is_deleted = 1;

        if($user->save()) { 
            return back()->with('success','Məlumat silindi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

}