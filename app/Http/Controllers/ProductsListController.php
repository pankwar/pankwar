<?php

namespace App\Http\Controllers;

use App\Models\Products_List;
use Illuminate\Http\Request;

class ProductsListController extends Controller
{
    public function getProductList(){
        return (new Products_List)->getProductList();
    }

    public function getAllProducts(){
        return (new Products_List)->getAllProducts();
    }
}
