<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserAppealRoles;

class HomeController extends Controller
{
    public function index() 
    {
        $types = DB::select("select id, name, path from appeal_types where is_deleted=0");
        return view('home.index')->with(["types"=>$types]);
    }

    public function setStatus(Request $request) {

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