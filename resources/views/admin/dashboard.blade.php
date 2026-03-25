@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold mb-2">Dashboard</h1>
    <p class="text-zinc-400">Bem-vindo ao painel administrativo Unboxing</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
    <div class="bg-zinc-950 border border-zinc-800/50 p-6 rounded relative overflow-hidden">
        <p class="text-zinc-400 text-sm mb-2">Total de Pedidos</p>
        <p class="text-4xl font-bold">{{ $totalOrders }}</p>
    </div>
    <div class="bg-zinc-950 border border-zinc-800/50 p-6 rounded relative overflow-hidden">
        <p class="text-zinc-400 text-sm mb-2">Receita Total</p>
        <p class="text-4xl font-bold">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</p>
    </div>
    <div class="bg-zinc-950 border border-zinc-800/50 p-6 rounded relative overflow-hidden">
        <p class="text-zinc-400 text-sm mb-2">Receita do Mês</p>
        <p class="text-4xl font-bold">R$ {{ number_format($currentMonthRevenue, 2, ',', '.') }}</p>
        @if($revenueGrowth != 0)
            <p class="text-sm mt-2 {{ $revenueGrowth > 0 ? 'text-green-400' : 'text-red-400' }}">
                {{ $revenueGrowth > 0 ? '↑' : '↓' }} {{ number_format(abs($revenueGrowth), 1) }}% vs mês anterior
            </p>
        @endif
    </div>
    <div class="bg-zinc-950 border border-zinc-800/50 p-6 rounded relative overflow-hidden">
        <p class="text-zinc-400 text-sm mb-2">Total de Produtos</p>
        <p class="text-4xl font-bold">{{ $totalProducts }}</p>
    </div>
</div>

<!-- Gráficos -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Gráfico de Vendas por Dia -->
    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <h2 class="text-xl font-bold mb-4">Vendas dos Últimos 30 Dias</h2>
        <div style="position: relative; height: 300px; width: 100%;">
            <canvas id="salesByDayChart"></canvas>
        </div>
    </div>

    <!-- Gráfico de Vendas por Fonte -->
    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <h2 class="text-xl font-bold mb-4">Vendas por Fonte</h2>
        <div style="position: relative; height: 300px; width: 100%;">
            <canvas id="salesBySourceChart"></canvas>
        </div>
    </div>
</div>

<!-- Produtos Mais Vendidos -->
<div class="bg-zinc-950 border border-zinc-800/50 rounded p-6 mb-6">
    <h2 class="text-xl font-bold mb-4">Produtos Mais Vendidos (Últimos 30 Dias)</h2>
    @if($topProducts->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-zinc-800">
                    <tr class="text-left text-sm text-zinc-400">
                        <th class="pb-3">Produto</th>
                        <th class="pb-3 text-center">Quantidade Vendida</th>
                        <th class="pb-3 text-right">Receita Gerada</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/30">
                    @foreach($topProducts as $product)
                        <tr>
                            <td class="py-3">{{ $product->name }}</td>
                            <td class="py-3 text-center font-semibold">{{ $product->total_quantity }}</td>
                            <td class="py-3 text-right font-semibold">R$ {{ number_format($product->total_revenue, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-zinc-500 text-sm">Nenhum produto vendido nos últimos 30 dias</p>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Orders -->
    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <h2 class="text-xl font-bold mb-4">Pedidos Recentes</h2>
        <div class="space-y-3">
            @forelse ($recentOrders as $order)
                <div class="flex justify-between items-center pb-3 border-b border-zinc-800/30">
                    <div>
                        <p class="font-semibold">{{ $order->order_number }}</p>
                        <p class="text-xs text-zinc-500">{{ $order->customer_name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold">R$ {{ number_format($order->total, 2, ',', '.') }}</p>
                        <p class="text-xs text-zinc-500">{{ $order->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-zinc-500 text-sm">Nenhum pedido recente</p>
            @endforelse
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <h2 class="text-xl font-bold mb-4">Produtos com Baixo Estoque</h2>
        <div class="space-y-3">
            @forelse ($lowStockProducts as $product)
                <div class="flex justify-between items-center pb-3 border-b border-zinc-800/30">
                    <div>
                        <p class="font-semibold text-sm">{{ $product->name }}</p>
                        <p class="text-xs text-zinc-500">{{ $product->category->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-orange-400">{{ $product->stock }} un.</p>
                    </div>
                </div>
            @empty
                <p class="text-zinc-500 text-sm">Todos os produtos têm estoque adequado</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Configuração global do Chart.js para tema dark
Chart.defaults.color = '#a1a1aa'; // zinc-400
Chart.defaults.borderColor = '#27272a'; // zinc-800
Chart.defaults.backgroundColor = '#18181b'; // zinc-900

// Gráfico de Vendas por Dia
const salesByDayCtx = document.getElementById('salesByDayChart').getContext('2d');
const salesByDayData = @json($salesByDayFormatted);

new Chart(salesByDayCtx, {
    type: 'line',
    data: {
        labels: salesByDayData.map(item => item.date),
        datasets: [{
            label: 'Receita (R$)',
            data: salesByDayData.map(item => item.total),
            borderColor: '#ffffff',
            backgroundColor: 'rgba(255, 255, 255, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointRadius: 3,
            pointBackgroundColor: '#ffffff',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const index = context.dataIndex;
                        const total = salesByDayData[index].total;
                        const count = salesByDayData[index].count;
                        return [
                            `Receita: R$ ${total.toFixed(2).replace('.', ',')}`,
                            `Pedidos: ${count}`
                        ];
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'R$ ' + value.toFixed(0);
                    }
                },
                grid: {
                    color: 'rgba(39, 39, 42, 0.5)'
                }
            },
            x: {
                grid: {
                    color: 'rgba(39, 39, 42, 0.5)'
                }
            }
        }
    }
});

// Gráfico de Vendas por Fonte
const salesBySourceCtx = document.getElementById('salesBySourceChart').getContext('2d');
const salesBySourceData = @json($salesBySource);

const sourceColors = {
    'Site': '#3b82f6',
    'OLX': '#a855f7',
    'Manual': '#eab308',
    'WhatsApp': '#22c55e',
    'Instagram': '#ec4899',
};

new Chart(salesBySourceCtx, {
    type: 'doughnut',
    data: {
        labels: salesBySourceData.map(item => item.source),
        datasets: [{
            data: salesBySourceData.map(item => item.total),
            backgroundColor: salesBySourceData.map(item => sourceColors[item.source] || '#71717a'),
            borderColor: '#000000',
            borderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
                position: 'right',
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const index = context.dataIndex;
                        const source = salesBySourceData[index];
                        const total = source.total;
                        const count = source.count;
                        return [
                            `${source.source}: R$ ${total.toFixed(2).replace('.', ',')}`,
                            `Pedidos: ${count}`
                        ];
                    }
                }
            }
        }
    }
});
</script>
@endpush
