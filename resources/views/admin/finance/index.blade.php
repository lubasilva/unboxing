@extends('layouts.admin')

@section('title', 'Financeiro')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold mb-2">Financeiro</h1>
            <p class="text-zinc-400">Gerencie todas as suas vendas</p>
        </div>
        <a href="{{ route('admin.finance.create') }}" 
           class="px-6 py-2 bg-white text-black font-medium hover:bg-zinc-200 transition-colors">
            + Adicionar Venda Manual
        </a>
    </div>
</div>

<!-- Estatísticas -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
    <div class="bg-zinc-950 border border-zinc-800/50 p-6 rounded">
        <p class="text-zinc-400 text-sm mb-2">Total de Vendas</p>
        <p class="text-3xl font-bold">R$ {{ number_format($stats['total_sales'], 2, ',', '.') }}</p>
    </div>
    
    <div class="bg-zinc-950 border border-zinc-800/50 p-6 rounded">
        <p class="text-zinc-400 text-sm mb-2">Total de Pedidos</p>
        <p class="text-3xl font-bold">{{ $stats['total_orders'] }}</p>
    </div>
    
    <div class="bg-zinc-950 border border-zinc-800/50 p-6 rounded">
        <p class="text-zinc-400 text-sm mb-2">Pedidos Pagos</p>
        <p class="text-3xl font-bold text-green-400">{{ $stats['paid_orders'] }}</p>
    </div>
    
    <div class="bg-zinc-950 border border-zinc-800/50 p-6 rounded">
        <p class="text-zinc-400 text-sm mb-2">Pedidos Pendentes</p>
        <p class="text-3xl font-bold text-yellow-400">{{ $stats['pending_orders'] }}</p>
    </div>
    
    <div class="bg-zinc-950 border border-zinc-800/50 p-6 rounded">
        <p class="text-zinc-400 text-sm mb-2">Vendas Manuais</p>
        <p class="text-3xl font-bold text-blue-400">R$ {{ number_format($stats['manual_sales'], 2, ',', '.') }}</p>
    </div>
</div>

<!-- Filtros -->
<div class="bg-zinc-950 border border-zinc-800/50 p-6 mb-6 rounded">
    <form method="GET" action="{{ route('admin.finance.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm text-zinc-400 mb-2">Período</label>
            <select name="period" class="w-full bg-black border border-zinc-800 text-white px-4 py-2 focus:outline-none focus:border-white">
                <option value="">Todos</option>
                <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hoje</option>
                <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Esta Semana</option>
                <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Este Mês</option>
                <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>Este Ano</option>
            </select>
        </div>

        <div>
            <label class="block text-sm text-zinc-400 mb-2">Fonte</label>
            <select name="source" class="w-full bg-black border border-zinc-800 text-white px-4 py-2 focus:outline-none focus:border-white">
                <option value="">Todas</option>
                <option value="system" {{ request('source') == 'system' ? 'selected' : '' }}>Site</option>
                <option value="olx" {{ request('source') == 'olx' ? 'selected' : '' }}>OLX</option>
                <option value="manual" {{ request('source') == 'manual' ? 'selected' : '' }}>Manual</option>
                <option value="whatsapp" {{ request('source') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                <option value="instagram" {{ request('source') == 'instagram' ? 'selected' : '' }}>Instagram</option>
            </select>
        </div>

        <div>
            <label class="block text-sm text-zinc-400 mb-2">Status de Pagamento</label>
            <select name="payment_status" class="w-full bg-black border border-zinc-800 text-white px-4 py-2 focus:outline-none focus:border-white">
                <option value="">Todos</option>
                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pendente</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Pago</option>
                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Falhou</option>
                <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Reembolsado</option>
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit" class="w-full bg-white text-black font-medium px-4 py-2 hover:bg-zinc-200 transition-colors">
                Filtrar
            </button>
        </div>
    </form>
</div>

<!-- Tabela de Vendas -->
<div class="bg-zinc-950 border border-zinc-800/50 rounded overflow-hidden">
    @if($orders->count() > 0)
        <table class="w-full">
            <thead class="border-b border-zinc-800">
                <tr class="text-left text-sm text-zinc-400">
                    <th class="px-6 py-4">Pedido</th>
                    <th class="px-6 py-4">Cliente</th>
                    <th class="px-6 py-4">Fonte</th>                                
                    <th class="px-6 py-4">Data</th>
                    <th class="px-6 py-4">Pagamento</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Total</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @foreach($orders as $order)
                    <tr class="text-white hover:bg-zinc-800/50 transition-colors">
                        <td class="px-6 py-4 font-mono text-sm">{{ $order->order_number }}</td>
                        <td class="px-6 py-4">{{ $order->customer_name }}</td>
                        <td class="px-6 py-4">
                            @php
                                $sourceColors = [
                                    'system' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                    'olx' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                                    'manual' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                                    'whatsapp' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                    'instagram' => 'bg-pink-500/10 text-pink-400 border-pink-500/20',
                                ];
                                $sourceLabels = [
                                    'system' => 'Site',
                                    'olx' => 'OLX',
                                    'manual' => 'Manual',
                                    'whatsapp' => 'WhatsApp',
                                    'instagram' => 'Instagram',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs border {{ $sourceColors[$order->source] ?? 'bg-zinc-500/10 text-zinc-400 border-zinc-500/20' }}">
                                {{ $sourceLabels[$order->source] ?? ucfirst($order->source) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-zinc-400">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $paymentColors = [
                                    'pending' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                                    'paid' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                    'failed' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                    'refunded' => 'bg-zinc-500/10 text-zinc-400 border-zinc-500/20',
                                ];
                                $paymentLabels = [
                                    'pending' => 'Pendente',
                                    'paid' => 'Pago',
                                    'failed' => 'Falhou',
                                    'refunded' => 'Reembolsado',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs border {{ $paymentColors[$order->payment_status] ?? '' }}">
                                {{ $paymentLabels[$order->payment_status] ?? ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                                    'processing' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                    'paid' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                    'shipped' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                                    'delivered' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                    'cancelled' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                ];
                                $statusLabels = [
                                    'pending' => 'Pendente',
                                    'processing' => 'Processando',
                                    'paid' => 'Pago',
                                    'shipped' => 'Enviado',
                                    'delivered' => 'Entregue',
                                    'cancelled' => 'Cancelado',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs border {{ $statusColors[$order->status] ?? '' }}">
                                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-semibold">
                            R$ {{ number_format($order->total, 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.pedidos.show', $order) }}" 
                               class="text-white hover:text-zinc-300 transition-colors">
                                Ver
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-zinc-800">
            {{ $orders->links() }}
        </div>
    @else
        <div class="px-6 py-12 text-center text-zinc-400">
            <p>Nenhuma venda encontrada.</p>
        </div>
    @endif
</div>
@endsection
