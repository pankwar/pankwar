<?php

namespace App\Http\Controllers;

use App\Models\DCProductList;
use Illuminate\Http\Request;

class DcProductListController extends Controller
{
    public function getDiscountCenterProductList($d_center_permalink){
        return (new DCProductList)->getDiscountCenterProductList($d_center_permalink);
    }
}
