<?php

namespace App\Http\Controllers;  
use App\Models\Questionnaires; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionnaireController extends Controller
{
    public function index() 
    {

        $list = DB::select("select * from questionnaires where is_deleted=0"); 
 
        return view('admin.questionnaire.index')->with(["list" => $list]);

    }


    public function create(Request $request)
    {
  
        $questionnaire = new Questionnaires();
        $questionnaire->title = $request->title; 
        $questionnaire->content = $request->content; 
        
        if($questionnaire->save()) { 

            return back()->with('success','Məlumat əlavə edildi');

        } else {

            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');

        }

    }

    public function fetchById($id) {

        $questionnaire = Questionnaires::find($id);

        return response()->json([
            'data' => $questionnaire,
            'error' => null,
        ]);
 
    }

    public function update($id, Request $request) {

        $questionnaire = Questionnaires::find($id); 
        $questionnaire->title = $request->title; 
        $questionnaire->content = $request->content;
        
        if($questionnaire->save()) { 
            return back()->with('success','Məlumat yeniləndi');
        } else { 
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }

    public function delete($id) {

        $questionnaire = Questionnaires::find($id);

        $questionnaire->is_deleted = 1;

        if($questionnaire->save()) { 
            return back()->with('success','Məlumat silindi');
        } else {
            return back()->with('error','Xəta baş verdi, zəhmət olmasa biraz sora yenidən cəhd edin');
        }

    }  

}