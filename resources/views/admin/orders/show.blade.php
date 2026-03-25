@extends('layouts.admin')

@section('title', 'Pedido ' . $order->order_number)

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-4xl font-bold mb-2">{{ $order->order_number }}</h1>
        <p class="text-zinc-400">Criado em {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <a href="{{ route('admin.pedidos.index') }}" class="px-6 py-3 bg-zinc-900 text-white font-semibold rounded hover:bg-zinc-800 transition">
        Voltar
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <h2 class="text-lg font-bold mb-4">Cliente</h2>
        <div class="space-y-2 text-sm">
            <p><span class="text-zinc-400">Nome:</span> {{ $order->customer_name }}</p>
            <p><span class="text-zinc-400">Email:</span> {{ $order->customer_email }}</p>
            <p><span class="text-zinc-400">Telefone:</span> {{ $order->customer_phone }}</p>
            <p><span class="text-zinc-400">Endereço:</span> {{ $order->customer_address ?: 'Não informado' }}</p>
        </div>
    </div>

    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <h2 class="text-lg font-bold mb-4">Pagamento</h2>
        <div class="space-y-2 text-sm">
            <p><span class="text-zinc-400">Método:</span> {{ $order->payment_method ?: 'Não definido' }}</p>
            <p><span class="text-zinc-400">Status:</span> {{ $order->payment_status }}</p>
            <p><span class="text-zinc-400">Payment ID:</span> {{ $order->payment_id ?: 'N/A' }}</p>
            <p><span class="text-zinc-400">Subtotal:</span> R$ {{ number_format($order->subtotal, 2, ',', '.') }}</p>
            <p><span class="text-zinc-400">Desconto:</span> R$ {{ number_format($order->discount, 2, ',', '.') }}</p>
            <p class="font-semibold"><span class="text-zinc-400">Total:</span> R$ {{ number_format($order->total, 2, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <h2 class="text-lg font-bold mb-4">Atualizar Pedido</h2>
        <form action="{{ route('admin.pedidos.update', $order) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="status" class="block text-sm font-semibold mb-2">Status do Pedido</label>
                <select id="status" name="status" class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition" required>
                    @foreach (['pending' => 'Pendente', 'processing' => 'Processando', 'paid' => 'Pago', 'shipped' => 'Enviado', 'delivered' => 'Entregue', 'cancelled' => 'Cancelado'] as $value => $label)
                        <option value="{{ $value }}" {{ old('status', $order->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="payment_status" class="block text-sm font-semibold mb-2">Status do Pagamento</label>
                <select id="payment_status" name="payment_status" class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition" required>
                    @foreach (['pending' => 'Pendente', 'paid' => 'Pago', 'failed' => 'Falhou', 'refunded' => 'Estornado'] as $value => $label)
                        <option value="{{ $value }}" {{ old('payment_status', $order->payment_status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="notes" class="block text-sm font-semibold mb-2">Notas</label>
                <textarea id="notes" name="notes" rows="4" class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">{{ old('notes', $order->notes) }}</textarea>
            </div>

            <button type="submit" class="w-full px-6 py-3 bg-white text-black font-semibold rounded hover:bg-zinc-200 transition">
                Salvar Alterações
            </button>
        </form>
    </div>
</div>

<div class="bg-zinc-950 border border-zinc-800/50 rounded overflow-hidden">
    <div class="px-6 py-4 border-b border-zinc-800/50">
        <h2 class="text-xl font-bold">Itens do Pedido</h2>
    </div>

    <table class="w-full">
        <thead class="border-b border-zinc-800/50">
            <tr>
                <th class="text-left px-6 py-4 text-sm font-semibold text-zinc-400">Produto</th>
                <th class="text-center px-6 py-4 text-sm font-semibold text-zinc-400">Qtd</th>
                <th class="text-right px-6 py-4 text-sm font-semibold text-zinc-400">Preço Unit.</th>
                <th class="text-right px-6 py-4 text-sm font-semibold text-zinc-400">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($order->items as $item)
                <tr class="border-b border-zinc-800/30">
                    <td class="px-6 py-4">
                        <p class="font-medium">{{ $item->product_name }}</p>
                        <p class="text-xs text-zinc-500">SKU: {{ $item->product?->sku ?: 'N/A' }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">{{ $item->quantity }}</td>
                    <td class="px-6 py-4 text-right">R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right font-semibold">R$ {{ number_format($item->getSubtotal(), 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-zinc-500">Este pedido não possui itens.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
