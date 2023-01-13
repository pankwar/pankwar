<?php

namespace App\Http\Controllers;

use App\Models\Sub_Categories;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoriesController extends Controller
{
    public function getSubCategory(){
        return (new Sub_Categories)->getSubCategory();
    }

    public function getSubCategoryByCategory($category_permalink){
        return (new Sub_Categories)->getSubCategoryByCategory($category_permalink);
    }
}
