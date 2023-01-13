<?php

namespace App\Http\Controllers;

use App\Models\SS_Discount_Center_Images;
use Illuminate\Http\Request;

class SSDiscountCenterImagesController extends Controller
{
    //

    public function updateLogoImage(Request $req, $d_center_id){
        return (new SS_Discount_Center_Images)->updateLogoImage($req, $d_center_id);
    }

    public function updateOwnerImage(Request $req, $d_center_id){
        return (new SS_Discount_Center_Images)->updateOwnerImage($req, $d_center_id);
    }

    public function updateCoverImage(Request $req, $d_center_id){
        return (new SS_Discount_Center_Images)->updateCoverImage($req, $d_center_id);
    }

    public function updateAadharImage(Request $req, $d_center_id){
        return (new SS_Discount_Center_Images)->updateAadharImage($req, $d_center_id);
    }

    public function updatePanImage(Request $req, $d_center_id){
        return (new SS_Discount_Center_Images)->updatePanImage($req, $d_center_id);
    }

    public function updateGstImage(Request $req, $d_center_id){
        return (new SS_Discount_Center_Images)->updateGstImage($req, $d_center_id);
    }

    public function getAllImagesByDiscountCenter($d_center_id){
        return (new SS_Discount_Center_Images)->getAllImagesByDiscountCenter($d_center_id);
    }

}
