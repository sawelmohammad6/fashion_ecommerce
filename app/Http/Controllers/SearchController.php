<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->active();

        if ($q = $request->get('q')) {
            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('name', 'LIKE', "%{$q}%")
                    ->orWhere('description', 'LIKE', "%{$q}%")
                    ->orWhere('fabric', 'LIKE', "%{$q}%")
                    ->orWhere('color', 'LIKE', "%{$q}%")
                    ->orWhereHas('category', fn ($c) => $c->where('name', 'LIKE', "%{$q}%"));
            });
        }

        if ($category = $request->get('category')) {
            $query->whereHas('category', fn ($c) => $c->where('slug', $category));
        }

        if ($fabric = $request->get('fabric')) {
            $query->where('fabric', $fabric);
        }

        if ($color = $request->get('color')) {
            $query->where('color', $color);
        }

        if ($minPrice = $request->get('min_price')) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice = $request->get('max_price')) {
            $query->where('price', '<=', $maxPrice);
        }

        $sort = $request->get('sort', 'latest');
        $query->matchSort($sort);

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::active()->get();
        $fabrics = Product::active()->whereNotNull('fabric')->distinct()->pluck('fabric');
        $colors = Product::active()->whereNotNull('color')->distinct()->pluck('color');

        return view('search.index', compact('products', 'categories', 'fabrics', 'colors', 'q'));
    }
}
