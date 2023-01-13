<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class statecontroller extends Controller
{
    public function getState(){
        return (new State)->getState();
    }
}
