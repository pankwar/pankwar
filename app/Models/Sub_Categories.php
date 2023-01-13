<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sub_Categories extends Model
{
    use HasFactory;

    protected $table = "sub_categories";
    protected $primaryKey = "sub_category_id";
    public $timestamps = false;


    public function getSubCategory(){
        $data = DB::table('sub_categories')->get();
        $response["data"] = $data;
        return response()->json($data);
    }

    public function getSubCategoryByCategory($category_permalink){
        $data = DB::table('sub_categories')
                ->join('categories','categories.category_id','=','sub_categories.category_id')
                ->where('category_permalink', $category_permalink)->orderBy('sub_category_id', 'desc')
                ->get();

        $response["data"] = $data;
        return response()->json($response);
    }

}
