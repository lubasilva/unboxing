@extends('layouts.admin')

@section('title', 'Categorias')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-4xl font-bold mb-2">Categorias</h1>
        <p class="text-zinc-400">Gerencie as categorias de produtos</p>
    </div>
    <a href="{{ route('admin.categorias.create') }}" 
       class="px-6 py-3 bg-white text-black font-semibold rounded hover:bg-zinc-200 transition">
        Nova Categoria
    </a>
</div>

<!-- Categories Table -->
<div class="bg-zinc-950 border border-zinc-800/50 rounded overflow-hidden">
    <table class="w-full">
        <thead class="border-b border-zinc-800/50">
            <tr>
                <th class="text-left px-6 py-4 text-sm font-semibold text-zinc-400">Nome</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-zinc-400">Slug</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-zinc-400">Produtos</th>
                <th class="text-center px-6 py-4 text-sm font-semibold text-zinc-400">Ordem</th>
                <th class="text-center px-6 py-4 text-sm font-semibold text-zinc-400">Status</th>
                <th class="text-right px-6 py-4 text-sm font-semibold text-zinc-400">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr class="border-b border-zinc-800/30 hover:bg-zinc-900/50 transition">
                    <td class="px-6 py-4 font-medium">{{ $category->name }}</td>
                    <td class="px-6 py-4 text-zinc-400 text-sm font-mono">{{ $category->slug }}</td>
                    <td class="px-6 py-4 text-zinc-400 text-sm">{{ $category->products_count ?? $category->products()->count() }} produtos</td>
                    <td class="px-6 py-4 text-center text-zinc-400 text-sm">{{ $category->order }}</td>
                    <td class="px-6 py-4 text-center">
                        @if ($category->is_active)
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
                        <a href="{{ route('admin.categorias.edit', $category) }}" 
                           class="text-sm text-zinc-400 hover:text-white transition">
                            Editar
                        </a>
                        <form action="{{ route('admin.categorias.destroy', $category) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Tem certeza que deseja deletar esta categoria?')">
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
                        Nenhuma categoria cadastrada
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $categories->links() }}
</div>
@endsection
