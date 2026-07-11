<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', true)->get();
        $products = Product::with('category')
            ->where('status', true)
            ->latest()
            ->paginate(12);

        return view('products.index', compact('categories', 'products'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $categories = Category::where('status', true)->get();
        $products = Product::with('category')
            ->where('category_id', $category->id)
            ->where('status', true)
            ->latest()
            ->paginate(12);

        return view('products.index', compact('categories', 'products', 'category'));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'productAttributes.attribute', 'productAttributes.attributeValue'])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $related = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', true)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
