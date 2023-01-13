<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";
    protected $primaryKey = "category_id";
    public $timestamp = false;

    public function getCategory(){
      $data = DB::table('categories')->select('*')->get();
      $response["data"] = $data;
      return response()->json($response);
    }
}
