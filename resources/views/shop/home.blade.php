@extends('layouts.shop')

@section('content')
<!-- Hero Section -->
<section class="relative h-[80vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-zinc-900 to-black"></div>
    
    <div class="relative z-10 text-center px-4">
        <h1 class="text-6xl md:text-8xl font-bold tracking-tighter mb-6">
            UNBOXING
        </h1>
        <p class="text-2xl md:text-3xl text-zinc-400 mb-12 font-light">
            Abra. Descubra.
        </p>
        <a href="{{ route('shop.products.index') }}" 
           class="inline-block bg-white text-black px-12 py-4 font-bold hover:bg-zinc-200 transition uppercase tracking-wider">
            Explorar
        </a>
    </div>
</section>

<!-- Categories -->
@if($categories->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <h2 class="text-3xl font-bold mb-12">Categorias</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($categories as $category)
        <a href="{{ route('shop.category', $category->slug) }}" 
           class="group relative h-80 bg-zinc-900 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10"></div>
            <div class="relative z-20 h-full flex flex-col justify-end p-8">
                <h3 class="text-3xl font-bold mb-2 group-hover:translate-x-2 transition-transform">
                    {{ $category->name }}
                </h3>
                <p class="text-zinc-400 text-sm">{{ $category->description }}</p>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 bg-zinc-950/30">
    <h2 class="text-3xl font-bold mb-12">Destaques</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($featuredProducts as $product)
        <a href="{{ route('shop.products.show', $product->slug) }}" class="group">
            <div class="bg-zinc-900 aspect-square mb-4 overflow-hidden">
                @if($product->images && count($product->images) > 0)
                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-full flex items-center justify-center text-zinc-700">
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
                <p class="text-sm text-zinc-500">{{ $product->category->name }}</p>
                <div class="flex items-center gap-2">
                    @if($product->hasDiscount())
                        <span class="text-zinc-500 line-through text-sm">
                            R$ {{ number_format($product->compare_price, 2, ',', '.') }}
                        </span>
                        <span class="font-bold">
                            R$ {{ number_format($product->price, 2, ',', '.') }}
                        </span>
                    @else
                        <span class="font-bold">
                            R$ {{ number_format($product->price, 2, ',', '.') }}
                        </span>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>
@else
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class="text-center text-zinc-500">
        <svg class="w-24 h-24 mx-auto mb-4 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <p class="text-lg">Em breve, novos produtos.</p>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class="bg-gradient-to-r from-zinc-900 to-zinc-800 p-16 text-center">
        <h2 class="text-4xl font-bold mb-4">Estilo urbano. Identidade forte.</h2>
        <p class="text-zinc-400 mb-8">Curadoria exclusiva de produtos premium.</p>
        <a href="{{ route('shop.products.index') }}" 
           class="inline-block bg-white text-black px-8 py-3 font-bold hover:bg-zinc-200 transition uppercase tracking-wider">
            Ver todos os produtos
        </a>
    </div>
</section>
@endsection
