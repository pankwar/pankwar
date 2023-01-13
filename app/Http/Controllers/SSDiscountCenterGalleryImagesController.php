<?php

namespace App\Http\Controllers;

use App\Models\SS_Discount_Center_Gallery_Images;
use Illuminate\Http\Request;

class SSDiscountCenterGalleryImagesController extends Controller
{
    public function getDiscountCenterGalleryImages($d_center_permalink){
        return (new SS_Discount_Center_Gallery_Images)->getDiscountCenterGalleryImages($d_center_permalink);
    }
}
