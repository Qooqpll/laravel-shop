<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Models\Category;
use App\Models\Product;
use Barryvdh\Debugbar\Facades\Debugbar;

class MainController extends Controller
{
    public function index(ProductsFilterRequest $request)
    {
        $productQuery = Product::with('category');

        if($request->filled('price_from')) {
            $productQuery->where('price', '>=', $request->price_from);
        }

        if($request->filled('price_to')) {
            $productQuery->where('price', '<=', $request->price_to);
        }

        foreach (['hit', 'new', 'recommend'] as $field) {
            if($request->has($field)) {
                $productQuery->$field();
            }
        }

        $products = $productQuery->paginate(6)->withPath('?' . $request->getQueryString());

        return view('index', ['products' => $products]);
    }

    public function categories()
    {
        $categories = Category::get();
        return view('categories', compact('categories'));
    }

    public function product($category, $productCode)
    {
        $product = Product::byCode($productCode)->first();
        return view('product', ['product' => $product]);
    }

    public function category($code)
    {
        $category = Category::where('code', $code)->first();
        return view('category', compact('category'));
    }
}
