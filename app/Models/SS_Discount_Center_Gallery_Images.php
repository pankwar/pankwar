<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SS_Discount_Center_Gallery_Images extends Model
{
    use HasFactory;
    protected $table = "ss_discount_center_gallery_images";
    protected $primaryKey = "d_center_gallery_image_id";
    public $timestamp = false;

    public function get_D_Center_Id($d_center_permalink){
        $data = DB::table("ss_discount_centers")->select("d_center_id")
                ->where("d_center_permalink", $d_center_permalink)->first()->d_center_id;
        return $data;
    }


    public function getDiscountCenterGalleryImages($d_center_permalink){

        $d_center_id = $this->get_D_Center_Id($d_center_permalink);

        $data = DB::table("ss_discount_center_gallery_images")->where("d_center_id",$d_center_id)->get();

        $response["data"] = $data;
        return response()->json($response);
    }
}
