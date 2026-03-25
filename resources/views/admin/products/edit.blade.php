@extends('layouts.admin')

@section('title', 'Editar Produto')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold mb-2">Editar Produto</h1>
    <p class="text-zinc-400">Atualize as informações do produto</p>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.produtos.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Current Images -->
        @if($product->images && count($product->images) > 0)
        <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
            <h2 class="text-xl font-bold mb-6">Imagens Atuais</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($product->images as $index => $image)
                    <div class="relative group">
                        <img src="{{ $image }}" alt="Imagem {{ $index + 1 }}" class="w-full aspect-square object-cover rounded border border-zinc-800">
                        <label class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs cursor-pointer opacity-0 group-hover:opacity-100 transition">
                            <input type="checkbox" name="remove_images[]" value="{{ $index }}" class="mr-1">
                            Remover
                        </label>
                    </div>
                @endforeach
            </div>
            <p class="mt-4 text-sm text-zinc-500">Marque as imagens que deseja remover</p>
        </div>
        @endif

        <!-- Add New Images -->
        <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
            <h2 class="text-xl font-bold mb-6">Adicionar Novas Imagens</h2>
            
            <div>
                <label class="block text-sm font-semibold mb-2">Upload de Imagens</label>
                <input type="file" 
                       name="images[]" 
                       multiple
                       accept="image/jpeg,image/png,image/jpg,image/webp"
                       class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-zinc-800 file:text-white file:cursor-pointer hover:file:bg-zinc-700">
                <p class="mt-2 text-sm text-zinc-500">
                    Formatos aceitos: JPG, PNG, WEBP. Tamanho máximo: 2MB por imagem. Você pode selecionar múltiplas imagens.
                </p>
                @error('images.*')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Basic Info -->
        <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
            <h2 class="text-xl font-bold mb-6">Informações Básicas</h2>
            
            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold mb-2">Nome do Produto</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $product->name) }}"
                           class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-semibold mb-2">Categoria</label>
                    <select id="category_id" 
                            name="category_id"
                            class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition"
                            required>
                        <option value="">Selecione uma categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold mb-2">Descrição</label>
                    <textarea id="description" 
                              name="description" 
                              rows="5"
                              class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Pricing -->
        <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
            <h2 class="text-xl font-bold mb-6">Preço</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-semibold mb-2">Preço</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-500">R$</span>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               value="{{ old('price', $product->price) }}"
                               step="0.01"
                               min="0.01"
                               class="w-full pl-12 pr-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition"
                               required>
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Compare Price -->
                <div>
                    <label for="compare_price" class="block text-sm font-semibold mb-2">Preço De (opcional)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-500">R$</span>
                        <input type="number" 
                               id="compare_price" 
                               name="compare_price" 
                               value="{{ old('compare_price', $product->compare_price) }}"
                               step="0.01"
                               min="0"
                               class="w-full pl-12 pr-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">
                    </div>
                    <p class="mt-1 text-sm text-zinc-500">Preço original para mostrar desconto</p>
                    @error('compare_price')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Inventory -->
        <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
            <h2 class="text-xl font-bold mb-6">Estoque</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-semibold mb-2">Quantidade</label>
                    <input type="number" 
                           id="stock" 
                           name="stock" 
                           value="{{ old('stock', $product->stock) }}"
                           min="0"
                           class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition"
                           required>
                    @error('stock')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-sm font-semibold mb-2">SKU (opcional)</label>
                    <input type="text" 
                           id="sku" 
                           name="sku" 
                           value="{{ old('sku', $product->sku) }}"
                           class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">
                    <p class="mt-1 text-sm text-zinc-500">Código único do produto</p>
                    @error('sku')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Options -->
        <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
            <h2 class="text-xl font-bold mb-6">Opções</h2>
            
            <div class="space-y-4">
                <!-- Is Active -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="is_active" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                           class="w-5 h-5 bg-black border border-zinc-800/50 rounded">
                    <label for="is_active" class="ml-3 text-sm font-semibold">Produto ativo (visível na loja)</label>
                </div>

                <!-- Is Featured -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="is_featured" 
                           name="is_featured" 
                           value="1"
                           {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                           class="w-5 h-5 bg-black border border-zinc-800/50 rounded">
                    <label for="is_featured" class="ml-3 text-sm font-semibold">Produto em destaque</label>
                </div>
            </div>
        </div>

        <!-- Meta Info -->
        <div class="p-4 bg-zinc-950 border border-zinc-800/50 rounded text-sm text-zinc-400">
            <p><strong class="text-white">Slug:</strong> {{ $product->slug }}</p>
            <p><strong class="text-white">Criado em:</strong> {{ $product->created_at->format('d/m/Y H:i') }}</p>
            <p><strong class="text-white">Atualizado em:</strong> {{ $product->updated_at->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Actions -->
        <div class="flex items-center space-x-4 pt-6 border-t border-zinc-800/50">
            <button type="submit" 
                    class="px-8 py-3 bg-white text-black font-semibold rounded hover:bg-zinc-200 transition">
                Atualizar Produto
            </button>
            <a href="{{ route('admin.produtos.index') }}" 
               class="px-8 py-3 bg-zinc-900 text-white font-semibold rounded hover:bg-zinc-800 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
