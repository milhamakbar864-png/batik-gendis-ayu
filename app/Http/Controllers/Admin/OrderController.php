<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items.product');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('order_number', 'like', "%{$q}%")
                    ->orWhere('customer_name', 'like', "%{$q}%")
                    ->orWhere('customer_phone', 'like', "%{$q}%");
            });
        }

        if ($request->filled('order_status')) {
            $query->where('order_status', $request->order_status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        $counts = [
            'all' => Order::count(),
            'pending_verification' => Order::where('payment_status', 'pending_verification')->count(),
            'processing' => Order::where('order_status', 'processing')->count(),
            'shipped' => Order::where('order_status', 'shipped')->count(),
            'completed' => Order::where('order_status', 'completed')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'counts'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'items.variant', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    public function verifyPayment(Request $request, Order $order)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        if ($request->action === 'approve') {
            $order->update([
                'payment_status' => 'paid',
                'order_status' => $order->order_status === 'pending' ? 'processing' : $order->order_status,
                'admin_notes' => $request->admin_notes ?: 'Pembayaran telah diverifikasi valid oleh admin.',
            ]);
            return back()->with('success', 'Pembayaran pesanan ' . $order->order_number . ' berhasil diverifikasi (LUNAS).');
        } else {
            $order->update([
                'payment_status' => 'failed',
                'admin_notes' => $request->admin_notes ?: 'Bukti transfer tidak valid atau dana belum masuk.',
            ]);
            return back()->with('warning', 'Pembayaran ditandai tidak valid / ditolak.');
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,completed,cancelled',
            'tracking_number' => 'nullable|string|max:100',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        // Jika status diubah menjadi Dibatalkan (cancelled), kembalikan stok persediaan!
        if ($request->order_status === 'cancelled' && $order->order_status !== 'cancelled') {
            DB::transaction(function () use ($order, $request) {
                foreach ($order->items as $item) {
                    if ($item->variant_id) {
                        $variant = ProductVariant::find($item->variant_id);
                        if ($variant) {
                            $stockBefore = $variant->stock;
                            $stockAfter = $stockBefore + $item->quantity;

                            $variant->update(['stock' => $stockAfter]);

                            InventoryMovement::create([
                                'product_id' => $item->product_id,
                                'variant_id' => $item->variant_id,
                                'type' => 'in',
                                'reference_type' => 'order_cancelled',
                                'reference_number' => $order->order_number,
                                'quantity' => $item->quantity,
                                'stock_before' => $stockBefore,
                                'stock_after' => $stockAfter,
                                'unit_cost' => $item->buy_price,
                                'notes' => 'Pengembalian stok dari pembatalan pesanan ' . $order->order_number,
                                'created_by' => Auth::id(),
                            ]);
                        }
                    }
                }

                $order->update([
                    'order_status' => 'cancelled',
                    'admin_notes' => $request->admin_notes ?: 'Pesanan dibatalkan oleh admin, stok dikembalikan.',
                ]);
            });

            return back()->with('success', 'Pesanan berhasil dibatalkan dan kuantitas stok telah otomatis dikembalikan ke persediaan.');
        }

        $data = [
            'order_status' => $request->order_status,
            'admin_notes' => $request->admin_notes ?? $order->admin_notes,
        ];

        if ($request->filled('tracking_number')) {
            $data['tracking_number'] = $request->tracking_number;
        }

        $order->update($data);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function invoice(Order $order)
    {
        $order->load(['items.product', 'items.variant']);
        return view('admin.orders.invoice', compact('order'));
    }
}
