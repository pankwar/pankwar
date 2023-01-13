<?php

namespace App\Http\Controllers;

use PDO;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use App\Models\SSDiscounCenters;
use Illuminate\Support\Facades\DB;

class SSDiscounCentersController extends Controller
{

    public function getHomePageDiscountCenter(){
        return (new SSDiscounCenters)->getHomePageDiscountCenter();

    }

    public function getAllDiscountCenters(Request $req){
        return (new SSDiscounCenters)->getAllDiscountCenters($req);
    }

    public function getDiscountCenterSingle($d_center_permalink){

        return (new SSDiscounCenters)->getDiscountCenterSingle($d_center_permalink);
    }

    public function getDiscountCentersByCategory($category_permalink){
        return (new SSDiscounCenters)->getDiscountCentersByCategory($category_permalink);
    }

    public function getDiscountCentersBySubCategory($sub_category_permalink){
        return (new SSDiscounCenters)->getDiscountCentersBySubCategory($sub_category_permalink);
    }

    public function getDiscountCenterByProductList($product_permalink){
        return (new SSDiscounCenters)->getDiscountCenterByProductList($product_permalink);
    }

    public function discountCenterApply(){

        $states = (new State)->getStates();

        return view("discountcenterapply", ["states"=>$states]);
    }

    // this function is using for getting states for City dropdown

    public function getCitiesByState($state_id){
        // $cities = (new City)->getCitiesByState($state_id);

        echo json_encode(DB::table('cities')->where('state_id', $state_id)->get());
    }
}
