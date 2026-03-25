<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $items = [];

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product && $product->is_active) {
                $items[$productId] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity,
                ];
                $total += $product->price * $quantity;
            }
        }

        return view('shop.cart.index', compact('items', 'total'));
    }

    public function add(Product $product, Request $request)
    {
        if (!$product->is_active || $product->stock < 1) {
            return back()->with('error', 'Produto não disponível');
        }

        $quantity = (int) $request->input('quantity', 1);
        $quantity = max(1, min($quantity, $product->stock));

        $cart = session()->get('cart', []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + $quantity;

        session()->put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', 'Produto adicionado ao carrinho!');
    }

    public function update(Request $request, $productId)
    {
        $quantity = (int) $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $product = Product::find($productId);
            if ($product) {
                $cart[$productId] = min($quantity, $product->stock);
            }
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Carrinho atualizado!');
    }

    public function remove($productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);

        return back()->with('success', 'Produto removido do carrinho!');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Carrinho limpo!');
    }
}
