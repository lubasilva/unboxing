@extends('layouts.admin')

@section('title', 'Pedidos')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-4xl font-bold mb-2">Pedidos</h1>
        <p class="text-zinc-400">Acompanhe e gerencie os pedidos da loja</p>
    </div>
</div>

<div class="bg-zinc-950 border border-zinc-800/50 rounded overflow-hidden">
    <table class="w-full">
        <thead class="border-b border-zinc-800/50">
            <tr>
                <th class="text-left px-6 py-4 text-sm font-semibold text-zinc-400">Pedido</th>
                <th class="text-left px-6 py-4 text-sm font-semibold text-zinc-400">Cliente</th>
                <th class="text-center px-6 py-4 text-sm font-semibold text-zinc-400">Itens</th>
                <th class="text-right px-6 py-4 text-sm font-semibold text-zinc-400">Total</th>
                <th class="text-center px-6 py-4 text-sm font-semibold text-zinc-400">Status</th>
                <th class="text-center px-6 py-4 text-sm font-semibold text-zinc-400">Pagamento</th>
                <th class="text-right px-6 py-4 text-sm font-semibold text-zinc-400">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                @php
                    $statusLabel = [
                        'pending' => 'Pendente',
                        'processing' => 'Processando',
                        'paid' => 'Pago',
                        'shipped' => 'Enviado',
                        'delivered' => 'Entregue',
                        'cancelled' => 'Cancelado',
                    ][$order->status] ?? ucfirst($order->status);

                    $paymentStatusLabel = [
                        'pending' => 'Pendente',
                        'paid' => 'Pago',
                        'failed' => 'Falhou',
                        'refunded' => 'Estornado',
                    ][$order->payment_status] ?? ucfirst($order->payment_status);
                @endphp

                <tr class="border-b border-zinc-800/30 hover:bg-zinc-900/50 transition">
                    <td class="px-6 py-4">
                        <p class="font-semibold">{{ $order->order_number }}</p>
                        <p class="text-xs text-zinc-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium">{{ $order->customer_name }}</p>
                        <p class="text-xs text-zinc-500">{{ $order->customer_email }}</p>
                    </td>
                    <td class="px-6 py-4 text-center text-zinc-400">{{ $order->items->count() }}</td>
                    <td class="px-6 py-4 text-right font-semibold">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-block px-3 py-1 text-xs rounded border
                            @if ($order->status === 'delivered') bg-green-950/30 border-green-800/50 text-green-400
                            @elseif ($order->status === 'cancelled') bg-red-950/30 border-red-800/50 text-red-400
                            @elseif ($order->status === 'pending') bg-yellow-950/30 border-yellow-800/50 text-yellow-400
                            @else bg-zinc-800/30 border-zinc-700/50 text-zinc-300 @endif">
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-block px-3 py-1 text-xs rounded border
                            @if ($order->payment_status === 'paid') bg-green-950/30 border-green-800/50 text-green-400
                            @elseif ($order->payment_status === 'failed') bg-red-950/30 border-red-800/50 text-red-400
                            @elseif ($order->payment_status === 'refunded') bg-orange-950/30 border-orange-800/50 text-orange-400
                            @else bg-zinc-800/30 border-zinc-700/50 text-zinc-300 @endif">
                            {{ $paymentStatusLabel }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.pedidos.show', $order) }}" class="text-sm text-zinc-400 hover:text-white transition">
                            Ver detalhes
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-zinc-500">Nenhum pedido encontrado</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $orders->links() }}
</div>
@endsection
