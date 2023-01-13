<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DCProductList extends Model
{
    use HasFactory;

    protected $table = "dc_product_list";
    protected $primaryKey = "dc_product_list_id";
    public $timestamp = false;


    public function get_D_Center_Id($d_center_permalink){
        $data = DB::table("ss_discount_centers")->select("d_center_id")
                ->where("d_center_permalink", $d_center_permalink)->first()->d_center_id;
        return $data;
    }

    public function getDiscountCenterProductList($d_center_permalink){

     $select = [
         'dc_product_list_id',
         'd_center_id',
         'dc_product_list.product_id',
         'custom_product_image',
         'discount_upto',
         'discount_flat',
         'description',
         'dc_product_list.created_at',
         'product_name',
         'product_image',
         'product_permalink',
         'page_title',
         'meta_keywords',
         'meta_description'
     ];

     $d_center_id = $this->get_D_Center_Id($d_center_permalink);

     $data = DB::table('dc_product_list')->select($select)->where('d_center_id', $d_center_id)
      ->join('products_list', 'products_list.product_id', '=', 'dc_product_list.product_id')
      ->get();

      $response["data"] = $data;
      return response()->json($response);
    }
}
