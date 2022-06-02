<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index() 
    {
        return view('home.index');
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