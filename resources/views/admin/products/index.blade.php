@extends('layouts.admin')

@section('title', 'Produtos')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-4xl font-bold mb-2">Produtos</h1>
        <p class="text-zinc-400">Gerencie os produtos da loja</p>
    </div>
    <a href="{{ route('admin.produtos.create') }}" 
       class="px-6 py-3 bg-white text-black font-semibold rounded hover:bg-zinc-200 transition">
        Novo Produto
    </a>
</div>

<!-- Products Grid/Table -->
<div class="bg-zinc-950 border border-zinc-800/50 rounded overflow-hidden">
    <table class="w-full">
        <thead class="border-b border-zinc-800/50">
            <tr>
                <th class="text-left px-6 py-4 text-sm font-semibold text-zinc-400">Produto</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-zinc-400">Categoria</th>
                <th class="text-right px-6 py-4 text-sm font-semibold text-zinc-400">Preço</th>
                <th class="text-center px-6 py-4 text-sm font-semibold text-zinc-400">Estoque</th>
                <th class="text-center px-6 py-4 text-sm font-semibold text-zinc-400">Status</th>
                <th class="text-right px-6 py-4 text-sm font-semibold text-zinc-400">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr class="border-b border-zinc-800/30 hover:bg-zinc-900/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-zinc-900 rounded flex items-center justify-center text-zinc-600 text-xs">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <p class="font-medium">{{ $product->name }}</p>
                                @if ($product->is_featured)
                                    <span class="inline-block text-xs px-2 py-0.5 bg-yellow-950/30 border border-yellow-800/50 text-yellow-400 rounded mt-1">
                                        Destaque
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-zinc-400 text-sm">{{ $product->category->name }}</td>
                    <td class="px-6 py-4 text-right">
                        <p class="font-semibold">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                        @if ($product->compare_price && $product->compare_price > $product->price)
                            <p class="text-xs text-zinc-500 line-through">R$ {{ number_format($product->compare_price, 2, ',', '.') }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm {{ $product->stock > 0 ? 'text-zinc-400' : 'text-red-400' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if ($product->is_active)
                            <span class="inline-block px-3 py-1 bg-green-950/30 border border-green-800/50 text-green-400 text-xs rounded">
                                Ativo
                            </span>
                        @else
                            <span class="inline-block px-3 py-1 bg-zinc-800/30 border border-zinc-700/50 text-zinc-500 text-xs rounded">
                                Inativo
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <a href="{{ route('admin.produtos.edit', $product) }}" 
                           class="text-sm text-zinc-400 hover:text-white transition">
                            Editar
                        </a>
                        <form action="{{ route('admin.produtos.destroy', $product) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Tem certeza que deseja deletar este produto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-sm text-red-400 hover:text-red-300 transition">
                                Deletar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-zinc-500">
                        Nenhum produto cadastrado
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection
