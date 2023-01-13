<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SSDiscounCenters extends Model
{
    use HasFactory;
    protected $table = "ss_discount_centers";
    protected $primaryKey = "d_center_id";
    public $timestamp = false;


    public function getAllDiscountCenters($req){

        $limit = $req->limit;
        $skip = $req->skip;

        $select = array(
            'ss_discount_centers.d_center_id',
            'd_center_name',
            'd_center_contact',
            'd_center_contact2',
            'whats_app_no',
            'email_id',
            'd_center_permalink',
            'd_center_type',
            'ss_discount_centers.ribbon_text',
            'is_visible',
            'is_verified',
            'd_center_logo',
            'd_center_description',
            'categories.category_id',
            'address',
            'dc_views',
        );

        $data = DB::table('ss_discount_centers')
            ->select($select)
            ->join('discount_center_category', 'discount_center_category.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('ss_discount_center_images', 'ss_discount_center_images.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('ss_discount_center_company_details', 'ss_discount_center_company_details.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('categories', 'categories.category_id', '=', 'discount_center_category.category_id')
            ->where('ss_discount_centers.is_visible', 1)
            ->orderBy('ss_discount_centers.d_center_id','desc')->skip($skip)->limit($limit)->get();

        $response["total_record"] = SSDiscounCenters::count();
        $response["data"] = $data;

        return response()->json($response);

    }

    public function getHomePageDiscountCenter()
    {
        $select = array(
            'ss_discount_centers.d_center_id',
            'd_center_name',
            'd_center_contact',
            'd_center_contact2',
            'd_center_permalink',
            'd_center_type',
            'ss_discount_centers.ribbon_text',
            'is_visible',
            'is_verified',
            'd_center_logo',
            'unique_id',
            'sub_category_name',
            'sub_categories.sub_category_id',
            'dc_views',

        );

        $data = DB::table('discount_center_home_page')->select($select)
        ->join('ss_discount_centers','ss_discount_centers.d_center_id','=','discount_center_home_page.d_center_id')
        ->join('ss_discount_center_images', 'ss_discount_center_images.d_center_id', '=', 'ss_discount_centers.d_center_id')
        ->join('discount_center_sub_category', 'discount_center_sub_category.d_center_id', '=', 'ss_discount_centers.d_center_id')
        ->join('sub_categories', 'sub_categories.sub_category_id', '=', 'discount_center_sub_category.sub_category_id')
        ->orderBy('s_no','asc')->get();

        $response["data"] = $data;
        return response()->json($response);
    }

    public function incrementViews($d_center_permalink){

        $data = SSDiscounCenters::where('d_center_permalink', $d_center_permalink)->increment('dc_views');
        return $data;
    }


    public function getDiscountCenterSingle($d_center_permalink)
    {
        $increment = $this->incrementViews($d_center_permalink);

        $select = array(
            'ss_discount_centers.d_center_id',
            'd_center_name',
            'd_center_contact',
            'd_center_contact2',
            'd_center_permalink',
            'd_center_type',
            'ss_discount_centers.ribbon_text',
            'is_visible',
            'is_verified',
            'd_center_logo',
            'd_center_cover_image',
            'sub_category_name',
            'cover_page_text',
            'd_center_description',
            'd_center_contact_person',
            'whats_app_no',
            'discount_offered',
            'email_id',
            'address',
            'dc_views',
            'dc_page_title',
            'dc_meta_keyword',
            'dc_meta_description',
            'established_year',
            'timing_open',
            'timing_close',
        );
        $data = DB::table('ss_discount_centers')->select($select)
            ->join('ss_discount_center_images', 'ss_discount_center_images.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('ss_discount_center_company_details', 'ss_discount_center_company_details.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('discount_center_sub_category', 'discount_center_sub_category.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('sub_categories', 'sub_categories.sub_category_id', '=', 'discount_center_sub_category.sub_category_id')
            ->where('d_center_permalink', $d_center_permalink)->where('ss_discount_centers.is_visible', 1)
            ->get()->first();
        $response["data"] = $data;
        $response["increment"] = $increment;
        return response()->json($response);

    }

    // Rhis function is heavily Using for bycategory view
    public function getDiscountCentersByCategory($category_permalink)
    {
        $select = array(
            'ss_discount_centers.d_center_id',
            'd_center_name',
            'd_center_contact',
            'd_center_contact2',
            'whats_app_no',
            'email_id',
            'd_center_permalink',
            'd_center_type',
            'ss_discount_centers.ribbon_text',
            'is_visible',
            'is_verified',
            'd_center_logo',
            'd_center_description',
            'categories.category_id',
            'address',
        );

        $data = DB::table('ss_discount_centers')->select($select)
            ->join('discount_center_category', 'discount_center_category.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('ss_discount_center_images', 'ss_discount_center_images.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('ss_discount_center_company_details', 'ss_discount_center_company_details.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('categories', 'categories.category_id', '=', 'discount_center_category.category_id')
            ->where('category_permalink', $category_permalink)->where('ss_discount_centers.is_visible', 1)->get();

       $response["data"] = $data;
       return response()->json($response);

    }

    // Rhis function is heavily Using for filter view
    public function getDiscountCentersBySubCategory($sub_category_permalink)
    {
        $select = array(
            'ss_discount_centers.d_center_id',
            'd_center_name',
            'd_center_contact',
            'd_center_contact2',
            'whats_app_no',
            'email_id',
            'd_center_permalink',
            'd_center_type',
            'ss_discount_centers.ribbon_text',
            'is_visible',
            'is_verified',
            'd_center_logo',
            'd_center_description',
            'sub_categories.sub_category_id',
            'sub_categories.category_id',
            'address',
        );

        $data = DB::table('ss_discount_centers')->select($select)
            ->join('discount_center_sub_category', 'discount_center_sub_category.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('ss_discount_center_images', 'ss_discount_center_images.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('ss_discount_center_company_details', 'ss_discount_center_company_details.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('sub_categories', 'sub_categories.sub_category_id', '=', 'discount_center_sub_category.sub_category_id')
            ->where('sub_category_permalink', $sub_category_permalink)->where('ss_discount_centers.is_visible', 1)->get();

        $response["data"] = $data;
        return response()->json($response);
    }

    public function getDiscountCenterByProductList($product_permalink){
        $select = array(
            'ss_discount_centers.d_center_id',
            'd_center_name',
            'd_center_contact',
            'd_center_contact2',
            'whats_app_no',
            'email_id',
            'd_center_permalink',
            'd_center_type',
            'ss_discount_centers.ribbon_text',
            'is_visible',
            'is_verified',
            'd_center_logo',
            'd_center_description',
            'address',
            'product_name',
            'product_image',
            'product_permalink',
            'products_list.product_id',
            'products_list.page_title',
            'products_list.meta_keywords',
            'products_list.meta_description',
        );

        $data = DB::table('ss_discount_centers')->select($select)
            ->join('dc_product_list', 'dc_product_list.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('ss_discount_center_images', 'ss_discount_center_images.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('ss_discount_center_company_details', 'ss_discount_center_company_details.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('products_list', 'products_list.product_id', '=', 'dc_product_list.product_id')
            ->where('product_permalink', $product_permalink)->where('ss_discount_centers.is_visible', 1)->get();

       $response["data"] = $data;
       return response()->json($response);
    }
}
