<?php

namespace App\Http\Controllers;  
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 
use Validator;

class CountryAppealController extends Controller
{
      
    public function index()
    {
      
        $list = DB::select("select a.id, t.name as type, c.name as country, a.insure, a.full_name, a.mail, a.number, a.created_at as date 
        from visa_country_appeals a inner join visa_types t on a.type_id = t.id inner join countries c on t.country_id = c.id order by a.id desc");
    

        return view('admin.countryAppeal.index')->with(["list" => $list]);

    }
 


}
