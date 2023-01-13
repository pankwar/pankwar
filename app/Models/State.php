<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    protected $table = "states";
    protected $primaryKey = "state_id";
    public $timestamp = false;


    public function getState(){
        $select = array(
            "state_id",
            "state_name",
            "state_abbreviation",
        );
        $data = DB::table('states')->select($select)->get();
        $response["data"] = $data;
        return $response;
    }

}
