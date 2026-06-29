<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', true)->get();
        $featuredProducts = Product::with('category')->active()->featured()->latest()->limit(8)->get();
        $latestProducts = Product::with('category')->active()->latest()->limit(8)->get();
        $banner = Banner::active()->first();

        return view('home.index', compact('categories', 'featuredProducts', 'latestProducts', 'banner'));
    }
}
