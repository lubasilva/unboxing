<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Throwable;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $featuredProducts = Product::where('is_active', true)
                ->where('is_featured', true)
                ->with('category')
                ->latest()
                ->take(8)
                ->get();

            $categories = Category::where('is_active', true)
                ->orderBy('order')
                ->get();
        } catch (Throwable $e) {
            // Keeps the storefront online while infra (DB/migrations) is not ready.
            $featuredProducts = collect();
            $categories = collect();
        }

        return view('shop.home', compact('featuredProducts', 'categories'));
    }
}
