@extends('layouts.shop')

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold mb-8">Carrinho</h1>

    @if(count($items) > 0)
        <div class="space-y-6 mb-8">
            @foreach($items as $productId => $item)
            <div class="bg-zinc-950 border border-zinc-800/50 p-6 rounded flex gap-6">
                <!-- Product Image -->
                <div class="w-24 h-24 flex-shrink-0 bg-zinc-900 rounded overflow-hidden">
                    @if($item['product']->images && count($item['product']->images) > 0)
                        <img src="{{ $item['product']->images[0] }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-zinc-700">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="flex-1">
                    <a href="{{ route('shop.products.show', $item['product']->slug) }}" class="font-bold hover:text-zinc-300 transition">
                        {{ $item['product']->name }}
                    </a>
                    <p class="text-sm text-zinc-500 mt-1">{{ $item['product']->category->name }}</p>
                    <p class="font-bold mt-3">R$ {{ number_format($item['product']->price, 2, ',', '.') }}</p>
                </div>

                <!-- Quantity -->
                <form action="{{ route('cart.update', $productId) }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" name="quantity" value="0" class="px-2 py-1 hover:bg-zinc-900 transition text-red-400 text-sm">Remover</button>
                    <span class="px-3 py-1 bg-zinc-800 rounded">{{ $item['quantity'] }}</span>
                </form>

                <!-- Subtotal -->
                <div class="text-right">
                    <p class="text-sm text-zinc-500">Subtotal</p>
                    <p class="font-bold text-lg">R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Summary -->
        <div class="bg-zinc-950 border border-zinc-800/50 p-8 rounded mb-8">
            <div class="space-y-4 mb-6">
                <div class="flex justify-between">
                    <span class="text-zinc-400">Subtotal</span>
                    <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-zinc-400">Frete</span>
                    <span>Calcular no checkout</span>
                </div>
                <div class="border-t border-zinc-800 pt-4 flex justify-between text-lg font-bold">
                    <span>Total</span>
                    <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('shop.products.index') }}" class="flex-1 border border-zinc-800 text-center py-3 hover:bg-zinc-900 transition">
                    Continuar Comprando
                </a>
                <a href="{{ route('checkout.index') }}" class="flex-1 bg-white text-black font-bold py-3 hover:bg-zinc-200 transition">
                    Ir para Checkout
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-24 h-24 mx-auto text-zinc-800 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <p class="text-zinc-500 text-lg mb-8">Seu carrinho está vazio</p>
            <a href="{{ route('shop.products.index') }}" class="inline-block bg-white text-black px-8 py-3 font-bold hover:bg-zinc-200 transition uppercase tracking-wider">
                Explorar Produtos
            </a>
        </div>
    @endif
</section>
@endsection
