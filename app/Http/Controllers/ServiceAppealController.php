<?php

namespace App\Http\Controllers;  
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 
use Validator;

class ServiceAppealController extends Controller
{
      
    public function index()
    {
      
        $list = DB::select("select a.id, s.name as service, a.full_name, a.mail, a.number, a.created_at as date 
            from visa_service_appeals a inner join services s on a.service_id = s.id order by a.id desc");
    

        return view('admin.serviceAppeal.index')->with(["list" => $list]);

    }
 


}
