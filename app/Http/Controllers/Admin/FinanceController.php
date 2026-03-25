<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items.product')
            ->orderBy('created_at', 'desc');

        // Filtro por período
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
                case 'year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
        }

        // Filtro por fonte
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Filtro por status de pagamento
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->paginate(20);

        // Estatísticas
        $stats = [
            'total_sales' => Order::where('payment_status', 'paid')->sum('total'),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('payment_status', 'pending')->count(),
            'paid_orders' => Order::where('payment_status', 'paid')->count(),
            'manual_sales' => Order::where('source', '!=', 'system')
                                    ->where('payment_status', 'paid')
                                    ->sum('total'),
        ];

        return view('admin.finance.index', compact('orders', 'stats'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.finance.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'source' => 'required|string|max:50',
            'payment_method' => 'required|in:pix,credit_card,boleto,cash,transfer',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        
        try {
            // Calcular valores
            $subtotal = 0;
            foreach ($validated['items'] as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $discount = $validated['discount'] ?? 0;
            $total = $subtotal - $discount;

            // Criar pedido
            $order = Order::create([
                'order_number' => 'MAN-' . strtoupper(substr(uniqid(), -8)),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'] ?? 'nao@fornecido.com',
                'customer_phone' => $validated['customer_phone'],
                'source' => $validated['source'],
                'payment_method' => $validated['payment_method'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'status' => 'delivered',
                'payment_status' => 'paid',
                'notes' => $validated['notes'],
            ]);

            // Adicionar itens e reduzir estoque
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                
                // Verificar estoque
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Estoque insuficiente para o produto: {$product->name}");
                }

                // Criar item do pedido
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Reduzir estoque
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            return redirect()->route('admin.finance.index')
                ->with('success', 'Venda manual registrada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Erro ao registrar venda: ' . $e->getMessage());
        }
    }
}
