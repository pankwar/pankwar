<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class City extends Model
{
    use HasFactory;

    protected $table = "cities";
    protected $primaryKey = "city_id";
    public $timestamp = false;


    public function getCitiesByState($state_id){
        $select = array(
            'city_id',
            'city_name',
        );
        $data = DB::table('cities')->select($select)->where('state_id', $state_id)
                ->get();

        // dd($data);
        return $data;
    }
}
