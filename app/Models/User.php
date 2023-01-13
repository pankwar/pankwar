<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = "ss_users";
    protected $primaryKey = "ss_user_id";
    public $timestamp = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    public function isReCaptchaValid($rcToken)
    {
        $client = new Client([
            'base_uri' => 'https://google.com/recaptcha/api/',
            'timeout' => 5.0,
        ]);

        $response = $client->request('POST', 'siteverify', [
            'query' => [
                'secret' => '6LdgNO0dAAAAABUbcFm0CgnOL5AxkwRYnrRd5Gio',
                'response' => $rcToken,
            ],
        ]);

        $data = json_decode($response->getBody());

        if ($data->success && $data->score >= 0.5) {
            // dd($data);
            // return $data;
            return true;
        }
        // return $data;
        return false;
    }

    // public function checkUserAlreadyExist($req)
    // {
    //     $data = User::where(function ($query) use ($req) {
    //         $query->where("email", $req->input("email"))->orWhere("contact", $req->input("contact"));
    //     })->first();

    //     return $data;
    // }

    public function checkUserAlreadyExist($req)
    {
        $data = User::Where("contact", $req->input("contact"))->first();
        return $data;
    }

    public function Register($req)
    {
        $state_data = explode(" ", $req->state_id);

        $state_abbrevation = $state_data[0];
        $state_id = $state_data[1];

        // $isRecaptchaValid = $this->isReCaptchaValid($req->rcToken);

        // if ($isRecaptchaValid) {
            $rules = array(
                'full_name' => 'required | string | min:3 | max:30',
                // 'email' => 'max:64',
                'contact' => 'required | numeric | digits_between:10,10',
                'password' => 'required | min:8 | max:15',
            );

            $validation = Validator::make($req->all(), $rules);

            if ($validation->fails()) {
                $response["statuscode"] = 422;
                $response["message"] = $validation->errors();
                // $response["isRecaptchaValid"] = $isRecaptchaValid;
                return response()->json($response);
            } else {
                $alreadyExist = $this->checkUserAlreadyExist($req);

                if ($alreadyExist != null) {
                    $response["message"] = "already exist";
                    $response["statuscode"] = 400;
                    $response["data"] = $alreadyExist;
                    // $response["isRecaptchaValid"] = $isRecaptchaValid;
                    return response()->json($response);
                }

                $names = explode(" ", $req->input("full_name"));

                // dd($names);

                $data = new User();
                $data->first_name = ($names[0] == "" || count($names) == null) ? 'NA' : $names[0];
                $data->last_name = (($names[0] == "" || count($names) < 2)) ? 'NA' : $names[1];
                $data->full_name = $req->input("full_name");
                $data->contact = $req->input("contact");
                $data->email = $req->input("email");

                $data->s_p = $req->input("password");
                // $data->d_card_id = $req->d_center_id;
                $data->registered_for = 2;
                $data->is_verified = 0;
                $data->is_blocked = 1;
                $data->created_at = date('Y-m-d H:i:s', time());
                $data->agent_code = $req->input("agent_code");
                $data->save();

                $updateCustomerID = User::where('email', $req->input("email"))->first();
                $updateCustomerID->customer_id = $data->ss_user_id;
                $updateCustomerID->user_id = $data->ss_user_id . rand(0, 999999);
                $updateCustomerID->password = Hash::make($data->s_p);
                $updateCustomerID->save();

                $update_loaction = (new SS_User_Locations)->addUserLocation($req, $data->ss_user_id);

                // $create_discount_card = (new SS_Discount_Card)->generateCardNumber($req, $data->ss_user_id);

                $response["message"] = "Success";
                $response["statuscode"] = 200;
                $response["data"] = $data;
                $response["customerid"] = $updateCustomerID;
                $response["update_loaction"] = $update_loaction;
                // $response["isRecaptchaValid"] = $isRecaptchaValid;
                return response()->json($response);
            }
        // } else {
        //     $response["message"] = "It Seems Google Recaptcha3 Detected Bot Activity";
        //     $response["statuscode"] = 0;
        //     $response["isRecaptchaValid"] = $isRecaptchaValid;
        //     return response()->json($response);
        // }

    }

    public function Login($req)
    {

        // $isRecaptchaValid = $this->isReCaptchaValid($req->rcToken);

        // if ($isRecaptchaValid) {

            $rules = array(
                'contact' => 'required | numeric | digits_between:10,10',
                'password' => 'required | string | max:30',
            );

            $validation = Validator::make($req->all(), $rules);
            if ($validation->fails()) {
                $response["message"] = $validation->errors();
                $response["statuscode"] = 422;
                // $response["isRecaptchaValid"] = $isRecaptchaValid;
                return response()->json($response);
            } else {

                if (!Auth::attempt($req->only('contact', 'password'))) {
                    return response([
                        "message" => "Invalid Credentials!",
                        "statuscode" => 400,
                        // "isRecaptchaValid" => $isRecaptchaValid,
                    ]);
                }

                $user = Auth::user();

                if ($user->is_verified == 0) {

                    $update_verification_code = User::where('ss_user_id', $user->ss_user_id)->first();
                    $update_verification_code->verificaion_code = random_int(100000, 999999);
                    $update_verification_code->save();

                    $send_message = $this->sendTextMessage($update_verification_code->verificaion_code, $user->contact);

                    return response([
                        'message' => 'Not Verified, Please Verify Your Account',
                        'statuscode' => 402,
                        'data' => $update_verification_code,
                        'is_verified' => $user->is_verified,
                        'send_message' => $send_message,
                        // "isRecaptchaValid" => $isRecaptchaValid,
                    ]);
                }

                $token = $req->user()->createToken('token')->plainTextToken;
                $cookie = cookie('ss_user_tkn', $token, 60 * 24 * 365);

                return response([
                    'message' => 'success',
                    'statuscode' => 200,
                    'data' => $user,
                    // "isRecaptchaValid" => $isRecaptchaValid,
                ])->withCookie($cookie);
            }
        // } else {
        //     $response["message"] = "It Seems Google Recaptcha3 Detected Bot Activity";
        //     $response["statuscode"] = 0;
        //     $response["isRecaptchaValid"] = $isRecaptchaValid;
        //     return response()->json($response);
        // }
    }

    public function verifyAccount($req)
    {
            $data = DB::table('ss_users')->select('verificaion_code', 'contact', 'full_name', 's_p')->where('ss_user_id', $req->ss_user_id)->first();

            if ($req->verificaion_code == $data->verificaion_code) {

                if (!Auth::attempt(['contact' => $data->contact, 'password' => $data->s_p])) {
                    return response([
                        "message" => "Invalid Credentials!",
                        "statuscode" => 400,
                    ]);
                }

                $user = Auth::user(); // user data after login but before update

                $update_verification_status = User::where('ss_user_id', $user->ss_user_id)->first();
                $update_verification_status->verificaion_code = random_int(100000, 999999);
                $update_verification_status->is_verified = 1;
                $update_verification_status->save();

                $token = $req->user()->createToken('token')->plainTextToken;
                $cookie = cookie('ss_user_tkn', $token, 60 * 24 * 365);

                $user = Auth::user(); // fresh User data after update

                return response([
                    'message' => 'success',
                    'statuscode' => 200,
                    // 'user' => $user,
                    "data" => $update_verification_status,

                ])->withCookie($cookie);

            } else {
                $response["message"] = "Failed";
                $response["statuscode"] = 400;
                $response["data"] = $data;
            }
            return response()->json($response);
    }

    public function resendVerificationCode($req)
    {

        $user = DB::table("ss_users")->select('ss_user_id', 'is_verified', 'contact')->where('ss_user_id', $req->ss_user_id)->first();

        if ($user->is_verified == 0) {

            $update_verification_code = User::where('ss_user_id', $user->ss_user_id)->first();
            $update_verification_code->verificaion_code = random_int(100000, 999999);
            $update_verification_code->save();

            $send_message = $this->sendTextMessage($update_verification_code->verificaion_code, $user->contact);

            return response([
                'message' => 'success',
                'statuscode' => 200,
                'data' => $update_verification_code,
                'is_verified' => $user->is_verified,
                'send_message' => $send_message,
            ]);
        } else {
            return response([
                'message' => 'already verified',
                'statuscode' => 400,
                'is_verified' => $user->is_verified,
            ]);
        }
    }

    public function sendCode($req)
    {
            $update_verification_code = User::where('contact', $req->contact)->first();

            if($update_verification_code == null){
                return response([
                    'message' => 'Failed',
                    'statuscode' => 400,
                    'data' => $update_verification_code,
                ]);
            }

            $update_verification_code->verificaion_code = $update_verification_code->ss_user_id.random_int(100000, 999999);
            $update_verification_code->save();

            $send_message = $this->sendTextMessage($update_verification_code->verificaion_code, $req->contact);

            return response([
                'message' => 'success',
                'statuscode' => 200,
                'data' => $update_verification_code,
                'send_message' => $send_message,
            ]);
    }


    public function getUser()
    {
        $ss_user_id = Auth::user()->ss_user_id;

        $data = DB::table('ss_discount_card')->where('ss_user_id','=',$ss_user_id)->first();

        if($data == null){
            $user_data = DB::table('ss_users')->where('ss_users.ss_user_id', $ss_user_id)->first();
        }else{
            $user_data = DB::table('ss_users')->where('ss_users.ss_user_id', $ss_user_id)
            ->join('ss_discount_card', 'ss_discount_card.ss_user_id','=','ss_users.ss_user_id')
            // ->join('ss_user_locations','ss_user_locations.ss_user_id','=','ss_users.ss_user_id')
            ->first();

        }

        $response["data"] = $user_data;
        return response()->json($response);

    }

    public function updateUser($req){
        $data = User::where('ss_user_id', Auth::user()->ss_user_id)->first();
        $data->first_name = $req->first_name;
        $data->last_name = $req->last_name;
        $data->full_name = $req->first_name . ' ' . $req->last_name;
        $data->age = $req->age;
        $data->gender = $req->gender;
        $data->created_at = date('Y-m-d H:i:s', time());
        $data->save();

        $response["statuscode"] = 200;
        $response["message"] = "success";
        $response["data"] = $data;

        return response()->json($response);
    }

    public function sendTextMessage($v_code, $contact)
    {
        // Account details
        $apiKey = urlencode('MzAzMjRkNDI1Nzc1Mzc1MTM0NGQ0NjQxNTk2YTdhMzI=');

        // Message details
        $numbers = array('91' . $contact);
        $sender = urlencode('SRVSML');
        $message = rawurlencode($v_code . ' is your servesmile verification code. Servesmile.');

        $numbers = implode(',', $numbers);

        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

        // Send the POST request with cURL
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        // Process your response here
        return $response;
    }

    public function changePassword($req){

        $data = User::where('verificaion_code', $req->verificaion_code)->first();

        if($data == null){
            return response()->json([
                'statuscode' => 400,
                'message' => "failed",
                'data' => $data
            ]);
        }

        $data->s_p = $req->input("password");
        $data->save();

        $update_password = User::where('verificaion_code', $req->verificaion_code)->first();
        $update_password->password = Hash::make($data->s_p);
        $update_password->verificaion_code = 0;
        $update_password->updated_at = date('Y-m-d H:i:s', time());
        $update_password->save();

        return response()->json([
            'statuscode' => 200,
            'message' => "success",
            'data' => $data
        ]);

    }

    public function logout()
    {
        $cookie = Cookie::forget('ss_user_tkn');
// Revoke the token that was used to authenticate the current request...
        // Auth::user()->currentAccessToken()->delete();
        return response()->json([
            'statuscode' => 200,
            'message' => "success",
        ])->withCookie($cookie);
    }

}
