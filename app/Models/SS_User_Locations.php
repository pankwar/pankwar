<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SS_User_Locations extends Model
{
    use HasFactory;

    protected $table = 'ss_user_locations';
    protected $primaryKey = "ss_user_location_id";
    public $timestamp = false;

    public function addUserLocation($req, $ss_user_id){

        $state = explode(" ",$req->input("state_id"));

        $state_id = $state[1];

        $data = new SS_User_Locations();
        $data->ss_user_id = $ss_user_id;
        $data->country_id = 1;
        $data->state_id = $state_id;
        $data->city_id = "0";
        $data->created_at = date('Y-m-d H:i:s', time());
        $data->updated_at = date('Y-m-d H:i:s', time());
        $data->save();
        return $data;
    }

    public function updateState($req){

        $data = SS_User_Locations::where('ss_user_id',Auth::user()->ss_user_id)->first();

        if($data == null){
            $data = new SS_User_Locations();
            $data->ss_user_id = Auth::user()->ss_user_id;
            $data->country_id = 1;
            $data->state_id = $req->state_id;
            $data->city_id = "0";
            $data->created_at = date('Y-m-d H:i:s', time());
            $data->updated_at = date('Y-m-d H:i:s', time());
            $data->save();
        }else{
            $data->state_id = $req->state_id;
            $data->updated_at = date('Y-m-d H:i:s', time());
            $data->save();
        }

        $response["statuscode"] = 200;
        $response["message"] = "success";
        $response["data"] = $data;

        return response()->json($response);
    }

    public function getUserState(){
        $data = SS_User_Locations::where('ss_user_id', Auth::user()->ss_user_id)->first();
        $response["data"] = $data;

        return response()->json($response);
    }
}
