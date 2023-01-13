<?php

namespace App\Http\Controllers;

use App\Models\Search;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    function Search(Request $req){

       return (new Search)->Search($req->search_term, $req->discount, $req->limit, $req->skip);
    }
}
