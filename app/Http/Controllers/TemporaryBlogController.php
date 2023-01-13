<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemporaryBlogController extends Controller
{
    //
    function unityisstrength(){
      return view('blogs.unityisstrength');
    }

    function haryanvimansculpture(){
      return view('blogs.haryanvimansculpture');
    }

    function otherhalflivesindelhi(){
      return view('blogs.otherhalflivesindelhi');
    }
}
