<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Banner;

class IndexController extends Controller
{
    public function index()
    {
        //getting featured products
        $featuredItemCount = Product::where('is_featured', 'Yes')->where('status', 1)->count();
        $featuredItems = Product::where('is_featured', 'Yes')->where('status', 1)->get()->toArray();
        $featuredItemChunk = array_chunk($featuredItems, 4);
        $latestProducts = Product::orderBy('id', 'Desc')->limit(6)->where('status', 1)->get()->toArray();

        $page_name = "index";
        return view('front.index')->with(compact('page_name', 'featuredItems',
         'featuredItemCount', 'featuredItemChunk', 'latestProducts'));
    }
}

