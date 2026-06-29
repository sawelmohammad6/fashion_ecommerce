<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', function () {
    $products = Product::active()->get();
    $categories = Category::active()->get();

    return response()->view('sitemap', [
        'products' => $products,
        'categories' => $categories,
    ])->header('Content-Type', 'application/xml');
});
