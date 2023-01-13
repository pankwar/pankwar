<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SS_Slider_Banners extends Model
{
    use HasFactory;

    protected $table = "ss_slider_banners";
    protected $primaryKey = "ss_slider_banner_id";
    public $timestamps = false;

    public function getHomePageBanners(){
        $data = DB::table('ss_slider_banners')
                ->where('is_visible', 1)->where('for_where',1)->where('for_device', 1)->where('for_domain', 1)
                ->orderBy('s_no','asc')->get();
        $response["data"] = $data;
        return response()->json($response);
    }

    public function getHomePageBannersSmall(){
        $data = DB::table('ss_slider_banners')
                ->where('is_visible', 1)->where('for_where',1)->where('for_device', 2)->where('for_domain', 1)
                ->orderBy('s_no','asc')->get();
        $response["data"] = $data;
        return response()->json($response);
    }

    public function getOfferBanners(){
        $data = DB::table('ss_slider_banners')
                ->where('is_visible', 1)->where('for_where',2)->where('for_device', 1)->where('for_domain', 1)
                ->orderBy('s_no','asc')->get();
        $response["data"] = $data;
        return response()->json($response);
    }

    public function getOfferBannersSmall(){
        $data = DB::table('ss_slider_banners')
                ->where('is_visible', 1)->where('for_where',2)->where('for_device', 2)->where('for_domain', 1)
                ->orderBy('s_no','asc')->get();
        $response["data"] = $data;
        return response()->json($response);
    }

    public function getCategoryBanners(){
        $data = DB::table('ss_slider_banners')
                ->where('is_visible', 1)->where('for_where',3)->where('for_device', 1)->where('for_domain', 1)
                ->orderBy('s_no','asc')->get();
        $response["data"] = $data;
        return response()->json($response);
    }

    public function getCategoryBannersSmall(){
        $data = DB::table('ss_slider_banners')
                ->where('is_visible', 1)->where('for_where',3)->where('for_device', 2)->where('for_domain', 1)
                ->orderBy('s_no','asc')->get();
        $response["data"] = $data;
        return response()->json($response);
    }



}
