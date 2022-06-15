<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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

}