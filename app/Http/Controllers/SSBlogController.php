<?php

namespace App\Http\Controllers;

use App\Models\SS_Blog;
use Illuminate\Http\Request;

class SSBlogController extends Controller
{
    public function getAllBlog(){
        return (new SS_Blog)->getAllBlog();
    }

    public function getLatestBlogs(){
        return (new SS_Blog)->getLatestBlogs();
    }

    public function getLatestNews(){
        return (new SS_Blog)->getLatestNews();
    }

    public function getEvents(){
        return (new SS_Blog)->getEvents();
    }

    public function getSingleBlog($blog_permalink, $ss_blog_id){
        return (new SS_Blog)->getSingleBlog($blog_permalink, $ss_blog_id);
    }
}
