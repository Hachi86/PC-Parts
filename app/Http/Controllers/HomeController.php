<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::active()->featured()->inStock()->with('category')->take(8)->get();
        $latestProducts   = Product::active()->inStock()->with('category')->latest()->take(8)->get();
        $categories       = Category::active()->withCount('products')->take(8)->get();
        $saleProducts     = Product::active()->inStock()->whereNotNull('sale_price')->take(4)->get();

        return view('home', compact('featuredProducts', 'latestProducts', 'categories', 'saleProducts'));
    }

    public function about()
    {
        return view('about');
    }
}
