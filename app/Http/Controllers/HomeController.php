<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Contacts;
use App\Models\Services;
use App\Models\visaCalls;
use App\Models\UserAppealRoles;
use App\Models\VisaCountryAppeals;
use App\Models\UserAppeals;

class HomeController extends Controller
{
    public function index()
    { 
        $countries = DB::select("select c.id, c.name, c.picture, v.name as color, v.type as type from countries c left join visa_colors v on c.visa_color_id = v.id where c.status=1 ORDER BY c.name");
        $services = DB::select("select s.id, s.name, s.picture, s.content from services s where s.is_deleted=0");
        $contacts = DB::select("select * from contacts");
        // dd($contacts);
        return view('client-side.index')->with(["countries"=>$countries, "services" => $services, "contact"=>$contacts]);
    }

    public function tours()
    { 
        $list = DB::select("select * from tours where is_deleted=0"); 
        $contacts = DB::select("select * from contacts");
        return view('client-side.tours')->with(["list" => $list, "contact"=>$contacts]);
    }

    public function visaServices()
    { 
        $countries = DB::select("select c.id, c.name, c.price, c.picture, v.name as color, v.type as type from countries c left join visa_colors v on c.visa_color_id = v.id where c.status=1 ORDER BY c.name");
        $contacts = DB::select("select * from contacts");

        // dd($countries);
        return view('client-side.visaServices')->with(["countries"=>$countries, "contact"=>$contacts]);
    }

    public function searchCountry(Request $request) {

        $query = "";
        if(strlen($request->inputValue)>0) {
            $query .=  " and c.name LIKE '%".$request->inputValue."%'";
        }

        if(strlen($request->visaRequire) > 0) {
            $query .= " and c.visa_color_id = ".$request->visaRequire;
        }

        if(strlen($request->orderPrice) > 0) {
            $query .= " order by c.price asc ";
        } else {
            $query .= " order by c.name asc ";
        }

        // dd($query);
        $list = DB::select("select c.id, c.name, c.price, c.picture, v.name as color, v.type as type FROM `countries` c left join visa_colors v on c.visa_color_id = v.id WHERE c.status = 1".$query);
    
        return response()->json([
            'data' => $list,
            'error' => null,
        ]);

    }

    public function faq()
    { 
        $list = DB::select("select * from questionnaires where is_deleted=0"); 
        $contacts = DB::select("select * from contacts");
        return view('client-side.faq')->with(["list" => $list, "contact"=>$contacts]);
    }

    public function blog()
    { 
        $list = DB::select("select * from blogs where is_deleted=0"); 
        $contacts = DB::select("select * from contacts");
        return view('client-side.blog')->with(["list" => $list, "contact"=>$contacts]);
    }
    
    public function visaAppeal($id)
    { 
        $countries = DB::select("select c.id, c.name, c.picture, v.name as color, v.type as type, c.price from countries c left join visa_colors v on c.visa_color_id = v.id where c.id=?",[$id]);
        $types = DB::select("select id, name, period from visa_types where country_id = ?",[$id]);
        $contacts = DB::select("select * from contacts");
        // dd($countries);
        return view('client-side.visaAppeal')->with(["countries" => $countries, "contact"=>$contacts, "types"=>$types]);
    }

    public function serviceAppeal($id)
    { 
        $service = Services::find($id);
        $contacts = DB::select("select * from contacts");
        // dd($countries);
        return view('client-side.serviceAppeal')->with(["service" => $service, "contact"=>$contacts]);
    }

    public function appeal() 
    {
        $types = DB::select("select id, name, path from appeal_types where is_deleted=0");
        $contacts = DB::select("select * from contacts");
        return view('home.index')->with(["types"=>$types, "contact"=>$contacts]);
    }

    public function crm() {

        $currentDateTime = date("Y-m-d");

        $query = "";

        if(isset(auth()->user()->id) && auth()->user()->role==0) {
            $query .= " and v_c.operator_number=".auth()->user()->internal_number;
        }

        $calls = DB::select("select v_c.id as id, v_c.citizen_number, u.name, v_c.city, v_c.type,
            v_c.citizen_number, v_c.note, c.name as country, v_c.created_at from visa_calls v_c 
            left join countries c on v_c.country_id = c.id left join users u on 
            v_c.operator_number=u.internal_number where v_c.is_deleted=0 and v_c.created_at LIKE '%".$currentDateTime."%'".$query);

        $countries = DB::select("select c.id, c.name from countries c where c.status=1 ORDER BY c.name");
        // dd($calls);
        return view('admin.crm.index')->with(["countries"=>$countries, "calls"=>$calls, "contact"=>$contacts]);

    }

    public function createCall(Request $request) { 

        if(isset($request->token) && $request->token==='$2y$10$LiGhb4Dcpj3LDSgjm7q.auPu5clSdWLslv2cnz1QzRZU5J20Dbdqa') {
            $call = new visaCalls();

            $call->citizen_number = base64_decode($request->citizenNumber);
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
        } else {
            return response()->json([
                'data' => null,
                'error' => ["status"=>419, "message"=>"Authorization error"],
            ]);
        }

    }

    public function updateCall(Request $request) {
 
        $call = visaCalls::find($request->id);

        $call->type	= $request->request_type;
        $call->country_id = $request->country==0 ? null : $request->country;  
        $call->note = !isset($request->note) ? null : $request->note; 
        $call->wp_number = !isset($request->wp_number) ? null : $request->wp_number; 

        if($request->request_type == "1") {
            $call->document_date = $request->document_date;
            $call->city = !isset($request->city) ? null : $request->city; 
            $call->address = !isset($request->address) ? null : $request->address; 
            $call->has_travel = !isset($request->has_travel) ? null : $request->has_travel; 
            $call->family_case = !isset($request->family_case) ? null : $request->family_case; 
            $call->has_work = !isset($request->has_work) ? null : $request->has_work; 
            $call->has_bank_account = !isset($request->has_bank_account) ? null : $request->has_bank_account; 
        } else {
            $call->birthday = $request->birth_date;
            $call->full_name = !isset($request->full_name) ? null : $request->full_name; 
            $call->education = !isset($request->education) ? null : $request->education; 
            $call->document = !isset($request->document) ? null : $request->document; 
        }

         

        if($call->save()) {
    
            return back()->with('success','Məlumat yeniləndi');

        } else {

            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
            
        }

    }

    public function getCall($id) {

        $calls = DB::select("select * from visa_calls where is_deleted = 0 and id=?",[$id]);

        return response()->json([
            'data' => $calls,
            'error' => null,
        ]);
    }

    public function getCalls() {

        $currentDateTime = date("Y-m-d");

        $query = "";

        if(isset(auth()->user()->id) && auth()->user()->role==0) {
            $query .= " and v_c.operator_number=".auth()->user()->internal_number;
        }

        $calls = DB::select("select v_c.id as id, v_c.citizen_number, u.name, v_c.city, v_c.type,
            v_c.citizen_number, v_c.note, c.name as country, v_c.created_at from visa_calls v_c 
            left join countries c on v_c.country_id = c.id left join users u on 
            v_c.operator_number=u.internal_number where v_c.is_deleted=0 and v_c.created_at LIKE '%".$currentDateTime."%'".$query);

        return response()->json([
            'data' => $calls,
            'error' => null,
        ]);
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

    public function contact() {

        $list = DB::select("select * from contacts");
       
        return view('admin.contact.index')->with(["list" => $list]);
    }
    
    public function setContactStatus($id, $status) {

        $contact = Contacts::find($id); 
        $contact->is_deleted = $status==0 ? 1 : 0;

        if($contact->save()) { 
            return back()->with('success','Aktivlik yeniləndi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }


    public function newCountryAppeal(Request $request) {
 
        $appeal = new VisaCountryAppeals();

        $appeal->type_id = $request->type_of_visa; 
        $appeal->insure = $request->Ins_val; 
        $appeal->full_name = $request->name." ".$request->surName; 
        $appeal->mail = $request->mail; 
        $appeal->number = $request->number; 
        $appeal->mail = $request->mail; 

        if($appeal->save()) { 
            return back()->with('success','Müraciət uğurla göndərildi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

}