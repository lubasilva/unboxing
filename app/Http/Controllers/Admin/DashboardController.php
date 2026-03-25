<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        
        $recentOrders = Order::latest()->take(5)->get();
        $lowStockProducts = Product::where('stock', '<', 5)->where('is_active', true)->get();
        
        // Dados para gráfico de vendas por dia (últimos 30 dias)
        $salesByDay = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Preencher todos os dias (mesmo sem vendas)
        $salesByDayFormatted = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $sale = $salesByDay->firstWhere('date', $date);
            $salesByDayFormatted[] = [
                'date' => now()->subDays($i)->format('d/m'),
                'total' => $sale ? (float) $sale->total : 0,
                'count' => $sale ? $sale->count : 0,
            ];
        }

        // Dados para gráfico de vendas por fonte
        $salesBySource = Order::where('payment_status', 'paid')
            ->select('source', DB::raw('SUM(total) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('source')
            ->get()
            ->map(function ($item) {
                return [
                    'source' => $this->translateSource($item->source),
                    'total' => (float) $item->total,
                    'count' => $item->count,
                ];
            });

        // Produtos mais vendidos (últimos 30 dias)
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.payment_status', 'paid')
            ->where('orders.created_at', '>=', now()->subDays(30))
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // Vendas do mês atual vs mês anterior
        $currentMonthRevenue = Order::where('payment_status', 'paid')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total');

        $lastMonthRevenue = Order::where('payment_status', 'paid')
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total');

        $revenueGrowth = $lastMonthRevenue > 0 
            ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
            'totalCategories',
            'recentOrders',
            'lowStockProducts',
            'salesByDayFormatted',
            'salesBySource',
            'topProducts',
            'currentMonthRevenue',
            'revenueGrowth'
        ));
    }

    private function translateSource($source)
    {
        $translations = [
            'system' => 'Site',
            'olx' => 'OLX',
            'manual' => 'Manual',
            'whatsapp' => 'WhatsApp',
            'instagram' => 'Instagram',
        ];

        return $translations[$source] ?? ucfirst($source);
    }
}
