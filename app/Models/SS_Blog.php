<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SS_Blog extends Model
{
    use HasFactory;

    protected $table = "ss_blog";
    protected $primaryKey = "ss_blog_id";
    public $timestamp = false;

    public function getAllBlog(){
        $data = DB::table("ss_blog")->orderBy('ss_blog_id','desc')->get();

        $response["data"] = $data;
        return response()->json($response);
    }

    public function getLatestBlogs(){
        $data = DB::table("ss_blog")->orderBy('ss_blog_id','desc')->get()->take(5);
        $response["data"] = $data;
        return response()->json($response);
    }

    public function getLatestNews(){
        $data =  DB::table('ss_blog')->where('blog_type', 3)->orderBy('ss_blog_id','desc')->get();
        $response["data"] = $data;
        return response()->json($response);
    }

    public function getEvents(){
        $data = DB::table('ss_blog')->where('blog_type', 4)->orderBy('ss_blog_id','desc')->get();
        $response["data"] = $data;
        return response()->json($response);
    }

    public function getSingleBlog($blog_permalink, $ss_blog_id){
        $data = DB::table("ss_blog")->where('ss_blog_id', $ss_blog_id)->first();

        $data->blog_detail = html_entity_decode($data->blog_detail);

        $response["data"] = $data;
        return response()->json($response);
    }
}
