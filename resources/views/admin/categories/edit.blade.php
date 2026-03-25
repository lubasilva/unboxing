@extends('layouts.admin')

@section('title', 'Editar Categoria')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold mb-2">Editar Categoria</h1>
    <p class="text-zinc-400">Atualize as informações da categoria</p>
</div>

<div class="max-w-2xl">
    <form action="{{ route('admin.categorias.update', $category) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold mb-2">Nome</label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', $category->name) }}"
                   class="w-full px-4 py-3 bg-zinc-950 border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition"
                   required>
            @error('name')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-semibold mb-2">Descrição</label>
            <textarea id="description" 
                      name="description" 
                      rows="4"
                      class="w-full px-4 py-3 bg-zinc-950 border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Order -->
        <div>
            <label for="order" class="block text-sm font-semibold mb-2">Ordem</label>
            <input type="number" 
                   id="order" 
                   name="order" 
                   value="{{ old('order', $category->order) }}"
                   min="0"
                   class="w-full px-4 py-3 bg-zinc-950 border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">
            <p class="mt-1 text-sm text-zinc-500">Ordem de exibição na loja</p>
            @error('order')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Is Active -->
        <div class="flex items-center">
            <input type="checkbox" 
                   id="is_active" 
                   name="is_active" 
                   value="1"
                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                   class="w-5 h-5 bg-zinc-950 border border-zinc-800/50 rounded">
            <label for="is_active" class="ml-3 text-sm font-semibold">Categoria ativa</label>
        </div>

        <!-- Meta Info -->
        <div class="p-4 bg-zinc-950 border border-zinc-800/50 rounded text-sm text-zinc-400">
            <p><strong class="text-white">Slug:</strong> {{ $category->slug }}</p>
            <p><strong class="text-white">Produtos:</strong> {{ $category->products()->count() }}</p>
            <p><strong class="text-white">Criada em:</strong> {{ $category->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Actions -->
        <div class="flex items-center space-x-4 pt-6 border-t border-zinc-800/50">
            <button type="submit" 
                    class="px-8 py-3 bg-white text-black font-semibold rounded hover:bg-zinc-200 transition">
                Atualizar Categoria
            </button>
            <a href="{{ route('admin.categorias.index') }}" 
               class="px-8 py-3 bg-zinc-900 text-white font-semibold rounded hover:bg-zinc-800 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
