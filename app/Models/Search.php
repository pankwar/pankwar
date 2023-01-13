<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Search extends Model
{
    use HasFactory;

    protected $table = "ss_discount_centers";
    protected $primaryKey = "d_center_id";
    public $timestamp = false;

    public function Search($search_term, $discount, $limit, $skip){


        $discount = (int)$discount;
        if($search_term == "all" || $search_term == "All" || $search_term == ""){
            $search_term = "";
        }
        if($discount == 100){
            $discount = 100;

        }

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
            'discount_offered',
            'city_name',
            'place_name',
            'market_name',
            'category_name',
            'sub_category_name',
            'product_name',
            'dc_product_list.product_id',
        );

        $data = DB::table('ss_discount_centers')
            ->select($select)
            ->where('discount_offered','<=', $discount)
            ->where('ss_discount_centers.is_visible', 1)
            ->where(function($query) use($search_term) {
             $query->where('d_center_name','like','%'.$search_term.'%')
                ->orWhere('category_name','like', '%'.$search_term.'%')
                ->orWhere('sub_category_name','like','%'.$search_term.'%')
                ->orWhere('state_name','like', '%'.$search_term.'%')
                ->orWhere('country_name','like', '%'.$search_term.'%')
                ->orWhere('city_name','like', '%'.$search_term.'%')
                ->orWhere('pincode','like', '%'.$search_term.'%')
                ->orWhere('near_by','like', '%'.$search_term.'%')
                ->orWhere('landmark','like', '%'.$search_term.'%')
                ->orWhere('place_name','like', '%'.$search_term.'%')
                ->orWhere('market_name','like', '%'.$search_term.'%')
                ->orwhere('product_name','like','%'.$search_term.'%');
            })
            ->join('discount_center_category', 'discount_center_category.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('discount_center_sub_category', 'discount_center_sub_category.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('ss_discount_center_location', 'ss_discount_center_location.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('ss_discount_center_images', 'ss_discount_center_images.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('ss_discount_center_company_details', 'ss_discount_center_company_details.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('dc_product_list', 'dc_product_list.d_center_id', '=', 'ss_discount_centers.d_center_id')
            ->join('categories', 'categories.category_id', '=', 'discount_center_category.category_id')
            ->join('sub_categories', 'sub_categories.sub_category_id', '=', 'discount_center_sub_category.sub_category_id')
            ->join('states', 'states.state_id', '=', 'ss_discount_center_location.state_id')
            ->join('country', 'country.country_id', '=', 'ss_discount_center_location.country_id')
            ->join('cities', 'cities.city_id', '=', 'ss_discount_center_location.city_id')
            ->join('places', 'places.place_id', '=', 'ss_discount_center_location.place_id')
            ->join('markets', 'markets.market_id', '=', 'ss_discount_center_location.market_id')
            ->join('products_list', 'products_list.product_id', '=', 'dc_product_list.product_id')
            ->inRandomOrder();

         $total_record =  count($data->get());
         $data =  $data->skip($skip)->limit($limit)->get();
         $response["data"] = $data;
         $response["total_record"] = $total_record;
         return response()->json($response);
    }
}
