<?php

namespace App\Http\Controllers;

use App\Models\SS_User_Locations;
use Illuminate\Http\Request;

class SSUserLocationsController extends Controller
{
    public function updateState(Request $req){
        return (new SS_User_Locations)->updateState($req);
    }

    public function getUserState(){
        return (new SS_User_Locations)->getUserState();
    }

}
