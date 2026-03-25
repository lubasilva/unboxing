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

        try {
            return response()->make(
                view('shop.home', compact('featuredProducts', 'categories'))->render()
            );
        } catch (Throwable $e) {
            return response()->make(
                <<<'HTML'
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unboxing</title>
    <style>
        body { background: #000; color: #fff; font-family: sans-serif; margin: 0; }
        main { min-height: 100vh; display: grid; place-items: center; padding: 24px; text-align: center; }
        h1 { font-size: 48px; margin-bottom: 16px; }
        p { color: #a1a1aa; max-width: 560px; }
        a { display: inline-block; margin-top: 24px; padding: 12px 20px; background: #fff; color: #000; text-decoration: none; font-weight: 700; }
    </style>
</head>
<body>
    <main>
        <div>
            <h1>UNBOXING</h1>
            <p>A loja esta online. Estamos finalizando os ultimos ajustes da vitrine.</p>
            <a href="/up">Verificar status</a>
        </div>
    </main>
</body>
</html>
HTML
            );
        }
    }
}
