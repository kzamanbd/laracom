<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request, $slug = null)
    {
        if ($slug) {
            return view('storefront.blog-show', ['slug' => $slug]);
        }

        return view('storefront.blog');
    }
}
