<?php

namespace App\Http\Controllers;

use App\Models\State;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\SS_Discount_Card;
use Illuminate\Support\Facades\DB;

class SSDiscountCardController extends Controller
{


    public function discountCardApply(){

        $states = (new State)->getStates();

        return view("discountcardapply", ["states"=>$states]);
    }

    public function generateCardNumber(Request $req){
        return (new SS_Discount_Card)->generateCardNumber($req);
    }

    public function getDiscountCard($ss_user_id){
        return (new SS_Discount_Card)->getDiscountCard($ss_user_id);
    }
}
