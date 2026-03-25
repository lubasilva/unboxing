@extends('layouts.admin')

@section('title', 'Adicionar Venda Manual')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <h1 class="text-4xl font-bold">Adicionar Venda Manual</h1>
        <a href="{{ route('admin.finance.index') }}" class="text-white hover:text-zinc-300">
            ← Voltar
        </a>
    </div>
</div>

@if(session('error'))
    <div class="bg-red-950/20 border border-red-800/50 rounded text-red-400 text-sm p-4 mb-6">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.finance.store') }}" class="space-y-6">
    @csrf

    <!-- Informações do Cliente -->
    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <h3 class="text-lg font-semibold text-white mb-4">Informações do Cliente</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm text-zinc-400 mb-2">Nome Completo *</label>
                <input type="text" 
                       name="customer_name" 
                       value="{{ old('customer_name') }}"
                       required
                       class="w-full bg-black border border-zinc-800 text-white px-4 py-2 focus:outline-none focus:border-white @error('customer_name') border-red-500 @enderror">
                @error('customer_name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-zinc-400 mb-2">Telefone *</label>
                <input type="text" 
                       name="customer_phone" 
                       value="{{ old('customer_phone') }}"
                       required
                       placeholder="(61) 99999-9999"
                       class="w-full bg-black border border-zinc-800 text-white px-4 py-2 focus:outline-none focus:border-white @error('customer_phone') border-red-500 @enderror">
                @error('customer_phone')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-zinc-400 mb-2">Email</label>
                <input type="email" 
                       name="customer_email" 
                       value="{{ old('customer_email') }}"
                       placeholder="opcional"
                       class="w-full bg-black border border-zinc-800 text-white px-4 py-2 focus:outline-none focus:border-white @error('customer_email') border-red-500 @enderror">
                @error('customer_email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Origem e Pagamento -->
    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <h3 class="text-lg font-semibold text-white mb-4">Origem e Pagamento</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm text-zinc-400 mb-2">Origem da Venda *</label>
                <select name="source" 
                        required
                        class="w-full bg-black border border-zinc-800 text-white px-4 py-2 focus:outline-none focus:border-white @error('source') border-red-500 @enderror">
                    <option value="">Selecione...</option>
                    <option value="olx" {{ old('source') == 'olx' ? 'selected' : '' }}>OLX</option>
                    <option value="manual" {{ old('source') == 'manual' ? 'selected' : '' }}>Manual (Loja Física)</option>
                    <option value="whatsapp" {{ old('source') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                    <option value="instagram" {{ old('source') == 'instagram' ? 'selected' : '' }}>Instagram</option>
                </select>
                @error('source')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-zinc-400 mb-2">Método de Pagamento *</label>
                <select name="payment_method" 
                        required
                        class="w-full bg-black border border-zinc-800 text-white px-4 py-2 focus:outline-none focus:border-white @error('payment_method') border-red-500 @enderror">
                    <option value="">Selecione...</option>
                    <option value="pix" {{ old('payment_method') == 'pix' ? 'selected' : '' }}>PIX</option>
                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Cartão de Crédito</option>
                    <option value="boleto" {{ old('payment_method') == 'boleto' ? 'selected' : '' }}>Boleto</option>
                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Dinheiro</option>
                    <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transferência</option>
                </select>
                @error('payment_method')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Produtos -->
    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <h3 class="text-lg font-semibold text-white mb-4">Produtos</h3>
        
        <div id="items-container">
            <div class="item-row grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-6">
                    <label class="block text-sm text-zinc-400 mb-2">Produto *</label>
                    <select name="items[0][product_id]" 
                            required
                            class="product-select w-full bg-black border border-zinc-800 text-white px-4 py-2 focus:outline-none focus:border-white">
                        <option value="">Selecione...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                    data-price="{{ $product->price }}"
                                    data-stock="{{ $product->stock }}">
                                {{ $product->name }} (Estoque: {{ $product->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm text-zinc-400 mb-2">Qtd *</label>
                    <input type="number" 
                           name="items[0][quantity]" 
                           min="1"
                           value="1"
                           required
                           class="quantity-input w-full bg-black border border-zinc-800 text-white px-4 py-2 focus:outline-none focus:border-white">
                </div>
                <div class="col-span-3">
                    <label class="block text-sm text-zinc-400 mb-2">Preço Unit. *</label>
                    <input type="number" 
                           name="items[0][price]" 
                           min="0"
                           step="0.01"
                           required
                           class="price-input w-full bg-black border border-zinc-800 text-white px-4 py-2 focus:outline-none focus:border-white">
                </div>
                <div class="col-span-1 flex items-end">
                    <button type="button" 
                            class="remove-item w-full bg-red-500/10 border border-red-500/20 text-red-400 px-3 py-2 hover:bg-red-500/20 transition-colors"
                            onclick="removeItem(this)"
                            style="display: none;">
                        ✕
                    </button>
                </div>
            </div>
        </div>

        <button type="button" 
                onclick="addItem()"
                class="mt-4 bg-white text-black font-medium px-4 py-2 hover:bg-zinc-200 transition-colors">
            + Adicionar Produto
        </button>
    </div>

    <!-- Desconto e Observações -->
    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm text-zinc-400 mb-2">Desconto (R$)</label>
                <input type="number" 
                       name="discount" 
                       min="0"
                       step="0.01"
                       value="{{ old('discount', 0) }}"
                       class="w-full bg-black border border-zinc-800 text-white px-4 py-2 focus:outline-none focus:border-white">
            </div>

            <div>
                <label class="block text-sm text-zinc-400 mb-2">Observações</label>
                <textarea name="notes" 
                          rows="3"
                          class="w-full bg-black border border-zinc-800 text-white px-4 py-2 focus:outline-none focus:border-white">{{ old('notes') }}</textarea>
            </div>
        </div>
    </div>

    <!-- Resumo -->
    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <div class="flex justify-between items-center text-lg">
            <span class="text-zinc-400">Subtotal:</span>
            <span class="text-white font-semibold" id="subtotal">R$ 0,00</span>
        </div>
        <div class="flex justify-between items-center text-lg mt-2">
            <span class="text-zinc-400">Desconto:</span>
            <span class="text-white font-semibold" id="discount-display">R$ 0,00</span>
        </div>
        <div class="flex justify-between items-center text-2xl mt-4 pt-4 border-t border-zinc-800">
            <span class="text-white font-bold">Total:</span>
            <span class="text-white font-bold" id="total">R$ 0,00</span>
        </div>
    </div>

    <!-- Botões -->
    <div class="flex justify-end gap-4">
        <a href="{{ route('admin.finance.index') }}" 
           class="px-6 py-2 border border-zinc-800 text-white hover:bg-zinc-800 transition-colors">
            Cancelar
        </a>
        <button type="submit" 
                class="px-6 py-2 bg-white text-black font-medium hover:bg-zinc-200 transition-colors">
            Registrar Venda
        </button>
    </div>
</form>

@push('scripts')
<script>
    let itemIndex = 1;

    function addItem() {
        const container = document.getElementById('items-container');
        const newItem = document.querySelector('.item-row').cloneNode(true);
        
        // Update input names
        newItem.querySelectorAll('input, select').forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace(/\[\d+\]/, `[${itemIndex}]`));
                if (input.tagName === 'INPUT') {
                    input.value = input.type === 'number' && input.name.includes('quantity') ? '1' : '';
                } else {
                    input.selectedIndex = 0;
                }
            }
        });
        
        // Show remove button for new items
        const removeBtn = newItem.querySelector('.remove-item');
        if (removeBtn) {
            removeBtn.style.display = 'block';
        }
        
        container.appendChild(newItem);
        itemIndex++;
        updateTotal();
    }

    function removeItem(button) {
        const container = document.getElementById('items-container');
        if (container.children.length > 1) {
            button.closest('.item-row').remove();
            updateTotal();
        }
    }

    // Auto-fill price when product is selected
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            const option = e.target.options[e.target.selectedIndex];
            const price = option.getAttribute('data-price');
            const row = e.target.closest('.item-row');
            const priceInput = row.querySelector('.price-input');
            if (price && priceInput) {
                priceInput.value = price;
            }
            updateTotal();
        }
    });

    // Update total on any change
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity-input') || 
            e.target.classList.contains('price-input') ||
            e.target.name === 'discount') {
            updateTotal();
        }
    });

    function updateTotal() {
        let subtotal = 0;
        
        document.querySelectorAll('.item-row').forEach(row => {
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            subtotal += quantity * price;
        });

        const discount = parseFloat(document.querySelector('input[name="discount"]').value) || 0;
        const total = subtotal - discount;

        document.getElementById('subtotal').textContent = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
        document.getElementById('discount-display').textContent = 'R$ ' + discount.toFixed(2).replace('.', ',');
        document.getElementById('total').textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
    }

    // Initialize
    updateTotal();
</script>
@endpush
@endsection
