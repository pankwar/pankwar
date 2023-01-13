<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function Register(Request $req){
        return (new User)->Register($req);
    }

    public function Login(Request $req){
        return (new User)->Login($req);
    }

    public function getUser(){
        return (new User)->getUser();
    }

    public function updateUser(Request $req){
        return (new User)->updateUser($req);
    }


    public function verifyAccount(Request $req){
        return (new User)->verifyAccount($req);
    }

    public function resendVerificationCode(Request $req){
        return (new User)->resendVerificationCode($req);
    }

    public function sendCode(Request $req){
        return (new User)->sendCode($req);
    }

    public function changePassword(Request $req){
        return (new User)->changePassword($req);
    }

    public function logout(){
        return (new User)->logout();
    }


}
