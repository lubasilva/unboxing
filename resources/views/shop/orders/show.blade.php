@extends('layouts.shop')

@section('content')
<section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <svg class="w-24 h-24 mx-auto text-green-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h1 class="text-4xl font-bold mb-2">Pedido Confirmado!</h1>
        <p class="text-zinc-400">Obrigado por sua compra. Seu pedido foi recebido.</p>
    </div>

    <!-- Order Details -->
    <div class="bg-zinc-950 border border-zinc-800/50 p-8 rounded mb-8">
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <p class="text-zinc-400 text-sm mb-1">Número do Pedido</p>
                <p class="text-2xl font-bold">{{ $order->order_number }}</p>
            </div>
            <div>
                <p class="text-zinc-400 text-sm mb-1">Data do Pedido</p>
                <p class="text-2xl font-bold">{{ $order->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <hr class="border-zinc-800 my-8">

        <div class="grid grid-cols-2 gap-8">
            <div>
                <h3 class="font-semibold mb-3">Dados Pessoais</h3>
                <p class="text-sm text-zinc-400">
                    {{ $order->customer_name }}<br>
                    {{ $order->customer_email }}<br>
                    {{ $order->customer_phone }}
                </p>
            </div>
            <div>
                <h3 class="font-semibold mb-3">Endereço de Entrega</h3>
                <p class="text-sm text-zinc-400">{{ $order->customer_address }}</p>
            </div>
        </div>
    </div>

    <!-- Items -->
    <div class="bg-zinc-950 border border-zinc-800/50 p-8 rounded mb-8">
        <h2 class="text-2xl font-bold mb-6">Itens do Pedido</h2>
        
        <div class="space-y-4">
            @foreach($order->items as $item)
            <div class="flex justify-between pb-4 border-b border-zinc-800">
                <div>
                    <p class="font-semibold">{{ $item->product_name }}</p>
                    <p class="text-sm text-zinc-500">Quantidade: {{ $item->quantity }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold">R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</p>
                    <p class="text-sm text-zinc-500">R$ {{ number_format($item->price, 2, ',', '.') }} un.</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6 pt-6 border-t border-zinc-800 text-right">
            <p class="text-zinc-400 mb-2">Total do Pedido</p>
            <p class="text-4xl font-bold">R$ {{ number_format($order->total, 2, ',', '.') }}</p>
        </div>
    </div>

    <!-- Status -->
    <div class="bg-zinc-950 border border-zinc-800/50 p-8 rounded mb-8">
        <h3 class="font-semibold mb-4">Status do Pedido</h3>
        <div class="space-y-3">
            <div class="flex items-center">
                <span class="w-3 h-3 bg-green-400 rounded-full mr-3"></span>
                <span class="text-sm">Pedido Recebido</span>
            </div>
            <div class="flex items-center opacity-50">
                <span class="w-3 h-3 bg-zinc-700 rounded-full mr-3"></span>
                <span class="text-sm">Pagamento Confirmado</span>
            </div>
            <div class="flex items-center opacity-50">
                <span class="w-3 h-3 bg-zinc-700 rounded-full mr-3"></span>
                <span class="text-sm">Preparando para Envio</span>
            </div>
            <div class="flex items-center opacity-50">
                <span class="w-3 h-3 bg-zinc-700 rounded-full mr-3"></span>
                <span class="text-sm">Enviado</span>
            </div>
            <div class="flex items-center opacity-50">
                <span class="w-3 h-3 bg-zinc-700 rounded-full mr-3"></span>
                <span class="text-sm">Entregue</span>
            </div>
        </div>
    </div>

    <div class="flex gap-4">
        <a href="{{ route('home') }}" class="flex-1 border border-zinc-800 text-center py-3 hover:bg-zinc-900 transition">
            Voltar à Loja
        </a>
        <a href="{{ route('shop.products.index') }}" class="flex-1 bg-white text-black font-bold py-3 hover:bg-zinc-200 transition">
            Continuar Comprando
        </a>
    </div>

    <div class="mt-8 p-4 bg-blue-950/20 border border-blue-800/50 rounded text-sm text-blue-400">
        <p class="font-semibold mb-2">Próximos Passos</p>
        <ul class="space-y-1 text-xs">
            <li>✓ Você receberá um email de confirmação em breve</li>
            <li>✓ Será necessário confirmar o pagamento no próximo passo</li>
            <li>✓ Assim que o pagamento for confirmado, você receberá um email de confirmação</li>
        </ul>
    </div>
</section>
@endsection
