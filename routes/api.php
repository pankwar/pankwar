<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\SSDiscounCenters;
use App\Http\Controllers\Controller;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SSBlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\JobTrainingSession;
use App\Http\Controllers\JobApplyFormController;
use App\Http\Controllers\UploadResumeController;
use App\Http\Controllers\TemporaryBlogController;
use App\Http\Controllers\RazorpayPaymentController;
use App\Http\Controllers\SSDiscounCentersController;
use App\Http\Controllers\CareerApplyDetailsController;
use App\Http\Controllers\DcProductListController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductsListController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SSDiscountCardController;
use App\Http\Controllers\SSDiscountCenterGalleryImagesController;
use App\Http\Controllers\SSDiscountCenterImagesController;
use App\Http\Controllers\SSSliderBannersController;
use App\Http\Controllers\SSUserLocationsController;
use App\Http\Controllers\statecontroller;
use App\Http\Controllers\SubCategoriesController;
use App\Http\Controllers\TemporaryDiscountCenterController;
use App\Models\Products_List;
use App\Models\SS_Discount_Center_Gallery_Images;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    route::get("/getuser", [AuthController::class, 'getUser']);
    route::post("/updateuser", [AuthController::class, 'updateUser']);
    route::post("/updatestate", [SSUserLocationsController::class, 'updateState']);
    route::get("/getuserstate", [SSUserLocationsController::class, 'getUserState']);

    route::post("/logout", [AuthController::class, 'logout']);


// discount card api

route::get("/getdiscountcard/{ss_user_id}", [SSDiscountCardController::class, 'getDiscountCard']);

route::post("/generatecardnumber", [SSDiscountCardController::class, 'generateCardNumber']);
});


// discount center api

route::get("/gethomepagediscountcenter", [SSDiscounCentersController::class, 'getHomePageDiscountCenter']);

route::post("/getalldiscountcenters", [SSDiscounCentersController::class, 'getAllDiscountCenters']);

route::get('/getdiscountcentersingle/{d_center_permalink}', [SSDiscounCentersController::class, "getDiscountCenterSingle"]);

route::get('/getdiscountcentersbycategory/{category_permalink}', [SSDiscounCentersController::class, 'getDiscountCentersByCategory']);
route::get('/getdiscountcentersbysubcategory/{sub_category_permalink}', [SSDiscounCentersController::class, 'getDiscountCentersBySubCategory']);
route::get("/getdiscountcenterbyproductlist/{product_permalink}", [SSDiscounCentersController::class, 'getDiscountCenterByProductList']);

// category api

route::get('/getcategory', [CategoryController::class, 'getCategory']);

route::get('/c', [CategoryController::class, 'Categories']); // shortUrl

//subcategory api

route::get('/getsubcategory', [SubCategoriesController::class, 'getSubCategory']);
route::get('/getsubcategorybycategory/{category_permalink}', [SubCategoriesController::class, 'getSubCategoryByCategory']);

//product api

route::get('/getproductlist', [ProductsListController::class, 'getProductList']);
route::get('/getallproducts', [ProductsListController::class, 'getAllProducts']);

//search api

Route::post('/search', [SearchController::class, 'Search']);


//blog api

route::get("/getlatestblogs", [SSBlogController::class, 'getLatestBlogs']);
route::get("/getallblog", [SSBlogController::class, 'getAllBlog']);
route::get('/bloglatestnews', [SSBlogController::class, 'getLatestNews']);
route::get('/blogevents', [SSBlogController::class, 'getEvents']);
route::get("/getsingleblog/{blog_permalink}/{ss_blog_id}",[SSBlogController::class, 'getSingleBlog']);

//banners api

route::get("/gethomepagebanners", [SSSliderBannersController::class, 'getHomePageBanners']);
route::get("/gethomepagebannerssmall", [SSSliderBannersController::class, 'getHomePageBannersSmall']);

route::get("/getofferbanners", [SSSliderBannersController::class, 'getOfferBanners']);
route::get("/getofferbannerssmall", [SSSliderBannersController::class, 'getOfferBannersSmall']);

route::get("/getcategorybanners", [SSSliderBannersController::class, 'getCategoryBanners']);
route::get("/getcategorybannerssmall", [SSSliderBannersController::class, 'getCategoryBannersSmall']);

// discount center gallery api

route::get("/getdiscountcentergalleryimages/{d_center_permalink}", [SSDiscountCenterGalleryImagesController::class, 'getDiscountCenterGalleryImages']);

// discount center product list api

route::get("/getdiscountcenterproductlist/{d_center_permalink}", [DcProductListController::class, 'getDiscountCenterProductList']);




// state api

route::get("/getstate",[statecontroller::class, 'getState'] );

route::post("/register", [AuthController::class, 'Register']);
route::post("/login", [AuthController::class, 'Login']);
route::post("/verifyaccount", [AuthController::class, 'verifyAccount']);
route::post("/resendverificationcode", [AuthController::class, 'resendVerificationCode']);
route::post("/sendcode", [AuthController::class, 'sendCode']);

route::post("/changepassword", [AuthController::class, 'changePassword']);







