<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with(['category', 'variants'])
            ->latest()
            ->take(6)
            ->get();

        $latestProducts = Product::where('is_active', true)
            ->with(['category', 'variants'])
            ->latest()
            ->take(8)
            ->get();

        $totalProducts = Product::where('is_active', true)->count();

        return view('home', compact(
            'categories',
            'featuredProducts',
            'latestProducts',
            'totalProducts'
        ));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
