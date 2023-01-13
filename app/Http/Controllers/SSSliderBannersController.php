<?php

namespace App\Http\Controllers;

use App\Models\SS_Slider_Banners;
use Illuminate\Http\Request;

class SSSliderBannersController extends Controller
{
    public function getHomePageBanners(){
        return (new SS_Slider_Banners)->getHomePageBanners();
    }

    public function getHomePageBannersSmall(){
        return (new SS_Slider_Banners)->getHomePageBannersSmall();
    }

    public function getOfferBanners(){
        return (new SS_Slider_Banners)->getOfferBanners();
    }

    public function getOfferBannersSmall(){
        return (new ss_slider_banners)->getOfferBannersSmall();
    }

    public function getCategoryBanners(){
        return (new SS_Slider_Banners)->getCategoryBanners();
    }

    public function getCategoryBannersSmall(){
        return (new SS_Slider_Banners)->getCategoryBannersSmall();
    }

}
