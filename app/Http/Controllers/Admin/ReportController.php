<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Laporan Penjualan & Laba / Rugi
     */
    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $ordersQuery = Order::whereIn('payment_status', ['paid'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->with('items');

        $orders = $ordersQuery->latest()->get();

        $totalRevenue = $orders->sum('total_amount');
        $totalSubtotal = $orders->sum('subtotal');
        $totalShipping = $orders->sum('shipping_cost');
        
        // Hitung total HPP dan Total Laba Bersih Penjualan
        $totalHpp = 0;
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $totalHpp += ($item->buy_price * $item->quantity);
            }
        }
        $netProfit = $totalSubtotal - $totalHpp;

        // Top 5 Produk Terlaris
        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_sales'))
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereIn('payment_status', ['paid'])
                  ->whereDate('created_at', '>=', $startDate)
                  ->whereDate('created_at', '<=', $endDate);
            })
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        $isPrint = $request->has('print');

        return view($isPrint ? 'admin.reports.sales-print' : 'admin.reports.sales', compact(
            'orders',
            'startDate',
            'endDate',
            'totalRevenue',
            'totalSubtotal',
            'totalShipping',
            'totalHpp',
            'netProfit',
            'topProducts'
        ));
    }

    /**
     * Laporan Persediaan & Nilai Aset Produk
     */
    public function inventory(Request $request)
    {
        $query = Product::with(['category', 'variants']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->get();
        $categories = Category::all();

        $totalStockUnits = 0;
        $totalAssetValue = 0;
        $totalRetailValue = 0;

        foreach ($products as $p) {
            $stock = $p->total_stock;
            $totalStockUnits += $stock;
            $totalAssetValue += ($stock * $p->buy_price);
            $totalRetailValue += ($stock * $p->price);
        }

        $potentialMargin = $totalRetailValue - $totalAssetValue;
        $isPrint = $request->has('print');

        return view($isPrint ? 'admin.reports.inventory-print' : 'admin.reports.inventory', compact(
            'products',
            'categories',
            'totalStockUnits',
            'totalAssetValue',
            'totalRetailValue',
            'potentialMargin'
        ));
    }
}
