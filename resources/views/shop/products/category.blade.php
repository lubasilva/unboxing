@extends('layouts.shop')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-2">{{ $category->name }}</h1>
        <p class="text-zinc-400">{{ $category->description }}</p>
    </div>

    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <a href="{{ route('shop.products.show', $product->slug) }}" class="group">
                <div class="bg-zinc-900 aspect-square mb-4 overflow-hidden">
                    @if($product->images && count($product->images) > 0)
                        <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" 
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
                        {{ $product->name }}
                    </h3>
                    <div class="flex items-center gap-2">
                        @if($product->hasDiscount())
                            <span class="text-zinc-500 line-through text-sm">
                                R$ {{ number_format($product->compare_price, 2, ',', '.') }}
                            </span>
                            <span class="font-bold text-green-400">
                                -{{ $product->getDiscountPercentage() }}%
                            </span>
                        @endif
                        <span class="font-bold">
                            R$ {{ number_format($product->price, 2, ',', '.') }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-zinc-500 text-lg">Nenhum produto encontrado nesta categoria</p>
        </div>
    @endif
</section>
@endsection
