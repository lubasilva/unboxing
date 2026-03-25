@extends('layouts.shop')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Product Image -->
        <div>
            @if($product->images && count($product->images) > 0)
                <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" 
                     class="w-full aspect-square object-cover rounded">
            @else
                <div class="w-full aspect-square bg-gradient-to-br from-zinc-800 to-zinc-900 flex items-center justify-center rounded">
                    <svg class="w-24 h-24 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="md:col-span-2">
            <div class="mb-6">
                <a href="{{ route('shop.category', $product->category->slug) }}" class="text-zinc-500 hover:text-white transition text-sm">
                    {{ $product->category->name }}
                </a>
                <h1 class="text-4xl font-bold mt-2">{{ $product->name }}</h1>
            </div>

            <!-- Price -->
            <div class="mb-8 pb-8 border-b border-zinc-800">
                <div class="flex items-end gap-4">
                    <span class="text-5xl font-bold">
                        R$ {{ number_format($product->price, 2, ',', '.') }}
                    </span>
                    @if($product->hasDiscount())
                        <div class="mb-2">
                            <span class="text-zinc-500 line-through">
                                R$ {{ number_format($product->compare_price, 2, ',', '.') }}
                            </span>
                            <p class="text-green-400 font-bold">
                                Economize -{{ $product->getDiscountPercentage() }}%
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Stock Status -->
            <div class="mb-8">
                @if($product->stock > 0)
                    <p class="text-green-400 font-semibold">Em estoque</p>
                @else
                    <p class="text-red-400 font-semibold">Fora de estoque</p>
                @endif
            </div>

            <!-- Description -->
            @if($product->description)
                <div class="mb-8 pb-8 border-b border-zinc-800">
                    <h2 class="text-lg font-semibold mb-3">Descrição</h2>
                    <p class="text-zinc-400 leading-relaxed">{{ $product->description }}</p>
                </div>
            @endif

            <!-- Add to Cart -->
            @if($product->stock > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <div class="flex gap-4 mb-8">
                        <div class="flex items-center border border-zinc-800 rounded">
                            <button type="button" class="px-4 py-2 hover:bg-zinc-900 transition" onclick="document.querySelector('input[name=quantity]').value = Math.max(1, parseInt(document.querySelector('input[name=quantity]').value) - 1)">−</button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center bg-transparent border-l border-r border-zinc-800">
                            <button type="button" class="px-4 py-2 hover:bg-zinc-900 transition" onclick="document.querySelector('input[name=quantity]').value = Math.min({{ $product->stock }}, parseInt(document.querySelector('input[name=quantity]').value) + 1)">+</button>
                        </div>
                        <button type="submit" class="flex-1 bg-white text-black font-bold py-3 hover:bg-zinc-200 transition uppercase tracking-wider">
                            Adicionar ao Carrinho
                        </button>
                    </div>
                </form>
            @endif

            <!-- SKU -->
            @if($product->sku)
                <div class="text-sm text-zinc-500">
                    <p>SKU: {{ $product->sku }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-24 pt-12 border-t border-zinc-800">
            <h2 class="text-3xl font-bold mb-8">Produtos Relacionados</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <a href="{{ route('shop.products.show', $related->slug) }}" class="group">
                    <div class="bg-zinc-900 aspect-square mb-4 overflow-hidden">
                        @if($related->images && count($related->images) > 0)
                            <img src="{{ $related->images[0] }}" alt="{{ $related->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-zinc-700 bg-gradient-to-br from-zinc-800 to-zinc-900">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <div class="space-y-1">
                        <h3 class="font-semibold group-hover:text-zinc-300 transition">
                            {{ $related->name }}
                        </h3>
                        <p class="font-bold">
                            R$ {{ number_format($related->price, 2, ',', '.') }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    @endif
</section>
@endsection
