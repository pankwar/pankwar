<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TemporaryDiscountCenterController extends Controller
{
    public function advertisehere(){
        return view('discountcenter.advertisehere');
    }
    public function beourdiscountcenter(){
        return view('discountcenter.beourdiscountcenter');
    }
    public function brandyourbusiness(){
        return view('discountcenter.brandyourbusiness');
    }
    public function civilworks(){
        return view('discountcenter.civilworks');
    }
    public function furnitureworld(){
        return view('discountcenter.furnitureworld');
    }
    public function interiorinnovation(){
        return view('discountcenter.interiorinnovation');
    }
    public function placeforyou(){
        return view('discountcenter.placeforyou');
    }
    public function youareourpartner(){
        return view('discountcenter.youareourpartner');
    }
}
