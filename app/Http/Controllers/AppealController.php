<?php

namespace App\Http\Controllers;
use App\Models\Appeals;
use App\Http\Controllers\ArchiveController;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 
use Validator;

class AppealController extends Controller
{
    
    // function create(Request $request) {

    //     $appeal = new Appeals();
    //     $appeal->name = $request->name;
    //     $appeal->surname = $request->surname;
    //     $appeal->number = $request->c_code.$request->number.$request->c_number;

    //     $users = DB::select("select id, name, status from users where is_deleted=0 and status=1");

    //     if(!empty($users)) {

    //         $randomIndex = rand(0, count($users)-1); 
    //         $appeal->user_id = $users[$randomIndex]->id;
    //         $appeal->step_id = 1;
 
    //     } else {
    //         $appeal->step_id = 2;
    //     }
    //     // dd($request->appeal_types);
    //     if($appeal->save()) { 

    //         if(isset($request->appeal_types) && count($request->appeal_types)>0){
    //             $appealTypes = [];
    //             foreach ($request->appeal_types as $item)
    //             {     

    //                 array_push($appealTypes, [
    //                     'appeal_id' => $appeal->id,
    //                     'type_id' => $item
    //                 ]);

    //             }

    //             $inserted = DB::table('appeal_selected_types')->insert($appealTypes);
    //             if($inserted) {
    //                 return back()->with('success','Müraciət göndərildi!');
    //             } else {
    //                 return back()->with('error','Xəta baş verdi(müraciət tipləri!), zəhmət olmasa biraz sora yenidən cəhd edin');
    //             }
    //         }
    //         return back()->with('success','Müraciət göndərildi!');
    //     } else {
    //         return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
    //     } 
        
    // }


    function create(Request $request) {
 
        $messages = [
            "name.required" => "Zəhmət olmasa adınızı daxil edin!",
            "surname.required" => "Zəhmət olmasa soyadınızı daxil edin!",
            "c_number.required" => "Zəhmət olmasa nömrənizi daxil edin!",
            "c_preffix.required" => "Zəhmət olmasa prefix daxil edin!",
            "c_code.required" => "Zəhmət olmasa ölkə kodu daxil edin!",
            "name.min" => "Ad üçün azı 3 simvol daxil edilməlidir!",
            "name.max" => "Ad üçün maksimum 22 simvol daxil edilə bilər!",
            "surname.min" => "Soyad üçün ən azı 3 simvol daxil edilməlidir!",
            "surname.max" => "Soyad üçün maksimum 22 simvol daxil edilə bilər!",
            "c_number.min" => "Nömrə üçün ən azı 3 simvol daxil edilməlidir!",
            "c_number.max" => "Nömrə üçün maksimum 7 simvol daxil edilə bilər!",
            "c_preffix.min" => "Prefix 2 simvol daxil edilməlidir!",
            "c_preffix.max" => "Prefix 2 simvol daxil edilməlidir!",
            "c_code.min" => "Ölkə kodu 4 simvol daxil edilməlidir!",
            "c_code.max" => "Ölkə kodu 4 simvol daxil edilməlidir!",
            // "appeal_types.integer" => "Müraciət tipi dəyəri rəqəm olmalıdır!",
        ];

        $validator = Validator::make($request->all(),[
            "name"=> "required|min:3|max:22",
            "surname"=> "required|min:3|max:22",
            "c_number"=> "required|min:3|max:7",
            "c_code"=> "required|min:4|max:4",
            "c_preffix"=> "required|min:2|max:2",
            // "appeal_types"=> "integer",
        ], $messages)->validate();

        if($validator) {

            $appeal = new Appeals();
            $appeal->name = $request->name;
            $appeal->surname = $request->surname;
            $appeal->number = $request->c_code.$request->c_preffix.$request->c_number;

            $usersWithAppeal = DB::select("select u.id, u.name, r.appeal_type_id as type from users u 
                inner join user_appeal_roles r on r.user_id = u.id where u.is_deleted=0 and u.status=1");
            
            $usersWithoutAppeal = DB::select("select id, name, status from users where is_deleted=0 and status=1");

            $userAppealList = [];
            // dd($usersWithAppeal);
            if(!empty($usersWithAppeal)) {

                if(isset($request->appeal_types) && count($request->appeal_types)>0) {
                
                    foreach ($request->appeal_types as $key => $item)
                    {     
                    
                        $new = array_values(array_filter($usersWithAppeal,function ($user) use ($item)
                        { 
                            return($user->type ==$item);
                        }));
    
                        $userId = null;
                        if(count($new)>0){
                            $randomIndex = rand(0, count($new)-1); 
                            $userId = $new[$randomIndex]->id;
                        }
                        
                        array_push($userAppealList, [
                            'user_id' => $userId,
                            'type_id' => $item
                        ]);

                    } 
                
                }
    
            } else if(!empty($usersWithoutAppeal)) {


                if(isset($request->appeal_types) && count($request->appeal_types)>0) {
                
                    foreach ($request->appeal_types as $key => $item)
                    {     
                        $randomIndex = rand(0, count($usersWithoutAppeal)-1);
                        array_push($userAppealList, [
                            'user_id' => $usersWithoutAppeal[$randomIndex]->id,
                            'type_id' => $item
                        ]);

                    } 
                
                }  
            }
            // dd($userAppealList);
            $appeal->step_id = count($userAppealList)>0 ? 1 : 2;
            
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
                    
                    $randomIndex = null;
                    if(count($usersWithoutAppeal)>0) {
                        $randomIndex = rand(0, count($usersWithoutAppeal)-1);
                    }
                    

                    $userAppealList = count($userAppealList)>0 ? array_map(function ($item) use ($appeal)
                    {
                        $item["appeal_id"] = $appeal->id;

                        return $item;

                    }, $userAppealList) : [
                        'user_id' => $randomIndex !== null ? $usersWithoutAppeal[$randomIndex]->id:null, 
                        'type_id' => null,
                        "appeal_id" => $appeal->id
                    ];


                    $userAppeals = DB::table('user_appeals')->insert($userAppealList);
                    $inserted = DB::table('appeal_selected_types')->insert($appealTypes);
                    if($inserted && $userAppeals) {
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
    }

    public function index()
    {
        $subQuery = "";
        $query = "";
        if(auth()->user()->role_id===1){
            $subQuery = " inner join user_appeals u_a on a.id = u_a.appeal_id ";
            $query = " and u_a.user_id=".auth()->user()->id;
        }
        

        $list = DB::select("select a.id, a.name, a.surname, a.number, s.name as step, a.created_at as date, s.id as stepId from appeals a inner join appeal_steps s on a.step_id = s.id".$subQuery." where a.status=1".$query);
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
