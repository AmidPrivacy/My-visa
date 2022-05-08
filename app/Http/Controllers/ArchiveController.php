<?php

namespace App\Http\Controllers;
use App\Models\Archives;
use Illuminate\Support\Facades\DB;
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

    function list($id, $category) {

        $list = DB::select("select a.id, a.operation, a.created_at, u.name as user from archives a inner join users u on a.user_id=u.id where a.row_id=? and a.category=?", [$id, $category]);

        return $list;
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
