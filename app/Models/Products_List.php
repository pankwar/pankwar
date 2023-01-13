<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Products_List extends Model
{
    use HasFactory;

    protected $table = "products_list";
    protected $primaryKey = "product_id";
    public $timestamp = false;


    public function getProductList(){
        $data = DB::table('products_list')->limit(42)->inRandomOrder()->get();

        $response["data"] = $data;
        return response()->json($response);
    }

    public function getAllProducts(){
        $data = DB::table('products_list')->orderBy('s_no','asc')->inRandomOrder()->get();

        $response["data"] = $data;
        return response()->json($response);
    }


}
