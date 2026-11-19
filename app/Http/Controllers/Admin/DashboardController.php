<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Metrik Keuangan & Penjualan
        $totalRevenue = Order::whereIn('payment_status', ['paid'])
            ->sum('total_amount');

        $monthlyRevenue = Order::whereIn('payment_status', ['paid'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        $totalOrdersCount = Order::count();
        $pendingOrdersCount = Order::where('order_status', 'pending')
            ->orWhere('payment_status', 'pending_verification')
            ->count();

        // 2. Metrik Persediaan (Inventory)
        $totalProductsCount = Product::count();
        $totalStockUnits = ProductVariant::sum('stock');
        
        // Total Nilai Aset Persediaan (Total Inventory Asset Value = Stok * Harga Beli)
        $inventoryAssetValue = Product::with('variants')->get()->sum(function ($product) {
            return $product->variants->sum('stock') * $product->buy_price;
        });

        // Produk dengan Stok Menipis / Kritis (Stok <= Safety Stock / min_stock)
        $lowStockProducts = Product::with(['category', 'variants'])
            ->get()
            ->filter(function ($p) {
                return $p->total_stock <= $p->min_stock;
            });

        // 3. Transaksi & Mutasi Terbaru
        $recentOrders = Order::latest()->take(6)->get();
        $recentMovements = InventoryMovement::with(['product', 'variant', 'creator'])
            ->latest()
            ->take(6)
            ->get();

        // 4. Data Statistik 7 Hari Terakhir
        $dailySales = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('d M');
            $sum = Order::whereIn('payment_status', ['paid'])
                ->whereDate('created_at', $date)
                ->sum('total_amount');
            $dailySales[] = [
                'date' => $label,
                'total' => (float) $sum,
            ];
        }

        return view('admin.dashboard', compact(
            'totalRevenue',
            'monthlyRevenue',
            'totalOrdersCount',
            'pendingOrdersCount',
            'totalProductsCount',
            'totalStockUnits',
            'inventoryAssetValue',
            'lowStockProducts',
            'recentOrders',
            'recentMovements',
            'dailySales'
        ));
    }
}
