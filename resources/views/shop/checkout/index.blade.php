@extends('layouts.shop')

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold mb-8">Checkout</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <form action="{{ route('checkout.store') }}" method="POST" class="lg:col-span-2 space-y-8">
            @csrf

            <!-- Dados Pessoais -->
            <div class="bg-zinc-950 border border-zinc-800/50 p-8 rounded">
                <h2 class="text-2xl font-bold mb-6">Dados Pessoais</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Nome Completo</label>
                        <input type="text" name="customer_name" required 
                               class="w-full bg-zinc-900 border border-zinc-800 rounded px-4 py-2 focus:outline-none focus:border-white transition @error('customer_name') border-red-500 @enderror"
                               value="{{ old('customer_name') }}">
                        @error('customer_name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Email</label>
                        <input type="email" name="customer_email" required 
                               class="w-full bg-zinc-900 border border-zinc-800 rounded px-4 py-2 focus:outline-none focus:border-white transition @error('customer_email') border-red-500 @enderror"
                               value="{{ old('customer_email') }}">
                        @error('customer_email') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Telefone</label>
                        <input type="tel" name="customer_phone" required 
                               class="w-full bg-zinc-900 border border-zinc-800 rounded px-4 py-2 focus:outline-none focus:border-white transition @error('customer_phone') border-red-500 @enderror"
                               value="{{ old('customer_phone') }}">
                        @error('customer_phone') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Endereço -->
            <div class="bg-zinc-950 border border-zinc-800/50 p-8 rounded">
                <h2 class="text-2xl font-bold mb-6">Endereço de Entrega</h2>
                
                <div>
                    <label class="block text-sm font-semibold mb-2">Endereço Completo</label>
                    <textarea name="customer_address" required rows="3"
                              class="w-full bg-zinc-900 border border-zinc-800 rounded px-4 py-2 focus:outline-none focus:border-white transition @error('customer_address') border-red-500 @enderror">{{ old('customer_address') }}</textarea>
                    @error('customer_address') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Método de Pagamento -->
            <div class="bg-zinc-950 border border-zinc-800/50 p-8 rounded">
                <h2 class="text-2xl font-bold mb-6">Método de Pagamento</h2>
                
                <div class="space-y-4">
                    <label class="flex items-center p-4 border border-zinc-800 rounded cursor-pointer hover:bg-zinc-900 transition">
                        <input type="radio" name="payment_method" value="pix" required class="mr-3" checked>
                        <div>
                            <p class="font-semibold">PIX</p>
                            <p class="text-sm text-zinc-400">Transferência instantânea</p>
                        </div>
                    </label>

                    <label class="flex items-center p-4 border border-zinc-800 rounded cursor-pointer hover:bg-zinc-900 transition">
                        <input type="radio" name="payment_method" value="credit_card" required class="mr-3">
                        <div>
                            <p class="font-semibold">Cartão de Crédito</p>
                            <p class="text-sm text-zinc-400">Parcelado em até 12x</p>
                        </div>
                    </label>

                    <label class="flex items-center p-4 border border-zinc-800 rounded cursor-pointer hover:bg-zinc-900 transition opacity-50">
                        <input type="radio" name="payment_method" value="boleto" disabled class="mr-3">
                        <div>
                            <p class="font-semibold">Boleto</p>
                            <p class="text-sm text-zinc-400">Em breve</p>
                        </div>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full bg-white text-black font-bold py-4 hover:bg-zinc-200 transition uppercase tracking-wider">
                Finalizar Compra
            </button>
        </form>

        <!-- Order Summary -->
        <div class="bg-zinc-950 border border-zinc-800/50 p-8 rounded h-fit">
            <h2 class="text-2xl font-bold mb-6">Resumo do Pedido</h2>

            <div class="space-y-4 mb-6 pb-6 border-b border-zinc-800">
                @foreach($items as $productId => $item)
                <div class="flex justify-between text-sm">
                    <span>
                        {{ $item['product']->name }}
                        <span class="text-zinc-500">x{{ $item['quantity'] }}</span>
                    </span>
                    <span>R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</span>
                </div>
                @endforeach
            </div>

            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-zinc-400">Subtotal</span>
                    <span>R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-zinc-400">Frete</span>
                    <span>Gratuito</span>
                </div>
                <div class="flex justify-between text-lg font-bold border-t border-zinc-800 pt-4 mt-4">
                    <span>Total</span>
                    <span>R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
