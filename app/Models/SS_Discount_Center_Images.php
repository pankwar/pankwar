<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SS_Discount_Center_Images extends Model
{
    use HasFactory;
    protected $table = "ss_discount_center_images";
    protected $primaryKey = "d_center_image_id";
    public $timestamp = false;

    public function saveDiscountCenterID($d_center_id){
        $details = new SS_Discount_Center_Images();
        $details->d_center_id = $d_center_id;
        $details->created_at = date('Y-m-d H:i:s', time());
        $details->updated_at = date('Y-m-d H:i:s', time());
        $details->save();
        return 1;
    }

    public function updateLogoImage($req, $d_center_id){
        $file = $req->file("logo_image");
        if($file!=null && ($file->extension() == "jpg" || $file->extension()=="png" || $file->extension()=="jpeg")){
            $uploadPath = "public/logoimages/";

            $oimageName = $file->getClientOriginalName();
            $originalmage = date('YmdHis', time()) . $oimageName;
            $file->move($uploadPath, $originalmage);

            $uploadPath2 = "http://127.0.0.1:8001/public/logoimages/";
            $file->move($uploadPath2, $originalmage);
        }else{
            $response["message"] = "Invalid Image Format! Only Jpg, Jpeg, and Png Allowed";
            $response["statuscode"] = 400;
            return response()->json($response);
        }

        $d_center_obj = SS_Discount_Center_Images::where('d_center_id', $d_center_id)->get()->first();
        $d_center_obj->d_center_logo = $originalmage;
        $d_center_obj->updated_at = date('Y-m-s H:i:s', time());

        try{
            $d_center_obj->save();
            $response["data"] = $d_center_obj;
            $response["statuscode"] = 200;
            $response["message"] = "Image Updated Successfuly";
            return response()->json($response);
        } catch(Exception $ex){
            $response["statuscode"] = 500;
            $response["exception"] = $ex;
            $response["message"] = "Failed! Server Error";
            return response()->json($response);
        }
    }

    public function updateOwnerImage($req, $d_center_id){
        $file = $req->file("owner_image");
        if($file!=null && ($file->extension() == "jpg" || $file->extension()=="png" || $file->extension()=="jpeg")){
            $uploadPath = "public/ownerimages/";
            $oimageName = $file->getClientOriginalName();
            $originalmage = date('YmdHis', time()) . $oimageName;
            $file->move($uploadPath, $originalmage);
        }else{
            $response["message"] = "Invalid Image Format! Only Jpg, Jpeg, and Png Allowed";
            $response["statuscode"] = 400;
            return response()->json($response);
        }

        $d_center_obj = SS_Discount_Center_Images::where('d_center_id', $d_center_id)->get()->first();
        $d_center_obj->d_center_owner_image = $originalmage;
        $d_center_obj->updated_at = date('Y-m-s H:i:s', time());

        try{
            $d_center_obj->save();
            $response["data"] = $d_center_obj;
            $response["statuscode"] = 200;
            $response["message"] = "Image Updated Successfuly";
            return response()->json($response);
        } catch(Exception $ex){
            $response["statuscode"] = 500;
            $response["exception"] = $ex;
            $response["message"] = "Failed! Server Error";
            return response()->json($response);
        }
    }

    public function updateCoverImage($req, $d_center_id){
        $file = $req->file("cover_image");
        if($file!=null && ($file->extension() == "jpg" || $file->extension()=="png" || $file->extension()=="jpeg")){
            $uploadPath = "public/coverimages/";
            $oimageName = $file->getClientOriginalName();
            $originalmage = date('YmdHis', time()) . $oimageName;
            $file->move($uploadPath, $originalmage);
        }else{
            $response["message"] = "Invalid Image Format! Only Jpg, Jpeg, and Png Allowed";
            $response["statuscode"] = 400;
            return response()->json($response);
        }

        $d_center_obj = SS_Discount_Center_Images::where('d_center_id', $d_center_id)->get()->first();
        $d_center_obj->d_center_cover_image = $originalmage;
        $d_center_obj->updated_at = date('Y-m-s H:i:s', time());

        try{
            $d_center_obj->save();
            $response["data"] = $d_center_obj;
            $response["statuscode"] = 200;
            $response["message"] = "Image Updated Successfuly";
            return response()->json($response);
        } catch(Exception $ex){
            $response["statuscode"] = 500;
            $response["exception"] = $ex;
            $response["message"] = "Failed! Server Error";
            return response()->json($response);
        }
    }

    public function updateAadharImage($req, $d_center_id){
        $file = $req->file("aadhar_image");
        if($file!=null && ($file->extension() == "jpg" || $file->extension()=="png" || $file->extension()=="jpeg")){
            $uploadPath = "public/aadharimages/";
            $oimageName = $file->getClientOriginalName();
            $originalmage = date('YmdHis', time()) . $oimageName;
            $file->move($uploadPath, $originalmage);
        }else{
            $response["message"] = "Invalid Image Format! Only Jpg, Jpeg, and Png Allowed";
            $response["statuscode"] = 400;
            return response()->json($response);
        }

        $d_center_obj = SS_Discount_Center_Images::where('d_center_id', $d_center_id)->get()->first();
        $d_center_obj->aadhar_card_image = $originalmage;
        $d_center_obj->updated_at = date('Y-m-s H:i:s', time());

        try{
            $d_center_obj->save();
            $response["data"] = $d_center_obj;
            $response["statuscode"] = 200;
            $response["message"] = "Image Updated Successfuly";
            return response()->json($response);
        } catch(Exception $ex){
            $response["statuscode"] = 500;
            $response["exception"] = $ex;
            $response["message"] = "Failed! Server Error";
            return response()->json($response);
        }
    }

    public function updatePanImage($req, $d_center_id){
        $file = $req->file("pan_image");
        if($file!=null && ($file->extension() == "jpg" || $file->extension()=="png" || $file->extension()=="jpeg")){
            $uploadPath = "public/panimages/";
            $oimageName = $file->getClientOriginalName();
            $originalmage = date('YmdHis', time()) . $oimageName;
            $file->move($uploadPath, $originalmage);
        }else{
            $response["message"] = "Invalid Image Format! Only Jpg, Jpeg, and Png Allowed";
            $response["statuscode"] = 400;
            return response()->json($response);
        }

        $d_center_obj = SS_Discount_Center_Images::where('d_center_id', $d_center_id)->get()->first();
        $d_center_obj->pan_card_image = $originalmage;
        $d_center_obj->updated_at = date('Y-m-s H:i:s', time());

        try{
            $d_center_obj->save();
            $response["data"] = $d_center_obj;
            $response["statuscode"] = 200;
            $response["message"] = "Image Updated Successfuly";
            return response()->json($response);
        } catch(Exception $ex){
            $response["statuscode"] = 500;
            $response["exception"] = $ex;
            $response["message"] = "Failed! Server Error";
            return response()->json($response);
        }
    }

    public function updateGstImage($req, $d_center_id){
        $file = $req->file("gst_image");
        if($file!=null && ($file->extension() == "jpg" || $file->extension()=="png" || $file->extension()=="jpeg")){
            $uploadPath = "public/gstimages/";
            $oimageName = $file->getClientOriginalName();
            $originalmage = date('YmdHis', time()) . $oimageName;
            $file->move($uploadPath, $originalmage);
        }else{
            $response["message"] = "Invalid Image Format! Only Jpg, Jpeg, and Png Allowed";
            $response["statuscode"] = 400;
            return response()->json($response);
        }

        $d_center_obj = SS_Discount_Center_Images::where('d_center_id', $d_center_id)->get()->first();
        $d_center_obj->gst_certificate_image = $originalmage;
        $d_center_obj->updated_at = date('Y-m-s H:i:s', time());

        try{
            $d_center_obj->save();
            $response["data"] = $d_center_obj;
            $response["statuscode"] = 200;
            $response["message"] = "Image Updated Successfuly";
            return response()->json($response);
        } catch(Exception $ex){
            $response["statuscode"] = 500;
            $response["exception"] = $ex;
            $response["message"] = "Failed! Server Error";
            return response()->json($response);
        }
    }

    public function getAllImagesByDiscountCenter($d_center_id){
        $data = SS_Discount_Center_Images::where('d_center_id', $d_center_id)->get()->first();
        $response["data"] = $data;
        return response()->json($response);
    }
}
