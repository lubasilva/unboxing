<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\FinanceController;
use Illuminate\Support\Facades\Route;

// Loja (Frontend)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produtos', [ShopProductController::class, 'index'])->name('shop.products.index');
Route::get('/produtos/{product:slug}', [ShopProductController::class, 'show'])->name('shop.products.show');
Route::get('/categoria/{category:slug}', [ShopProductController::class, 'category'])->name('shop.category');

// Carrinho
Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrinho/adicionar/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/carrinho/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrinho/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/carrinho', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/pedido/{order}', [CheckoutController::class, 'show'])->name('order.show');

// Admin - Rotas protegidas
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Configurações
    Route::get('/configuracoes', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/configuracoes', [SettingController::class, 'update'])->name('settings.update');
    
    // Financeiro
    Route::get('/financeiro', [FinanceController::class, 'index'])->name('finance.index');
    Route::get('/financeiro/adicionar', [FinanceController::class, 'create'])->name('finance.create');
    Route::post('/financeiro', [FinanceController::class, 'store'])->name('finance.store');
    
    // Categorias
    Route::resource('categorias', CategoryController::class)->parameters(['categorias' => 'category']);
    
    // Produtos
    Route::resource('produtos', ProductController::class)->parameters(['produtos' => 'product']);
    
    // Pedidos
    Route::resource('pedidos', OrderController::class)->parameters(['pedidos' => 'order'])->only(['index', 'show', 'update']);
});

// Profile (do Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
