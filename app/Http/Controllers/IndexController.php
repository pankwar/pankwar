<?php

namespace App\Http\Controllers;

use App\Models\SS_Blog;
use Illuminate\Http\Request;
use App\Models\SSDiscounCenters;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index(){
        $data = (new SSDiscounCenters)->getDiscountCenter();
        $blogData = (new SS_Blog)->getLatestBlogs();
        $bannerData = DB::table('ss_slider_banners')->where('is_visible', 1)->orderBy('s_no','asc')->get();
        // dd($data);
        // dd($blogData);
        // dd($bannerData);
        return view("index", ["data"=> $data, "blogData" => $blogData, "bannerData" => $bannerData]);
    }

    public function aboutus(){
        return view("aboutus");
    }

    public function getBanners(){

        return view('');
    }


}
