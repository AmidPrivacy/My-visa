<?php

namespace App\Http\Controllers;
use App\Models\Archives;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{

    function __construct(){
        $this->OPERATE = [
            'Yenisini yaratdı',
            'Məlumat oxundu',
            'Məlumat yeniləndi',
            'Məlumat silindi',
        ];
    }
   
    
    function create($type, $rowId, $operation) {
        $archive = new Archives();
        $archive->user_id = auth()->user()->id;
        $archive->category = $type;
        $archive->row_id = $rowId;
        // dd(OPERATE[0]);
        $archive->operation = $this->OPERATE[$operation];
        $archive->save();
    }

}
