<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderTrackingController extends Controller
{
    public function track(Request $request)
    {
        $order = null;
        if ($request->filled('search')) {
            $search = trim($request->search);
            $order = Order::where('order_number', $search)
                ->orWhere('customer_phone', $search)
                ->with(['items.product', 'items.variant'])
                ->latest()
                ->first();

            if (!$order) {
                return back()->with('error', "Pesanan dengan nomor/telepon '{$search}' tidak ditemukan. Mohon periksa kembali.");
            }
        }

        return view('orders.track', compact('order'));
    }

    public function payment(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product', 'items.variant'])
            ->firstOrFail();

        $bankAccounts = BankAccount::where('is_active', true)->get();

        return view('orders.payment', compact('order', 'bankAccounts'));
    }

    public function uploadProof(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
        ], [
            'payment_proof.required' => 'File bukti transfer wajib diunggah.',
            'payment_proof.image' => 'File harus berupa gambar (JPG, PNG, atau WEBP).',
            'payment_proof.max' => 'Ukuran gambar maksimal adalah 3 MB.',
        ]);

        if ($request->hasFile('payment_proof')) {
            // Delete old proof if exists
            if ($order->payment_proof && Storage::disk('public')->exists($order->payment_proof)) {
                Storage::disk('public')->delete($order->payment_proof);
            }

            $path = $request->file('payment_proof')->store('payment_proofs', 'public');

            $order->update([
                'payment_proof' => $path,
                'payment_status' => 'pending_verification',
                'payment_date' => now(),
            ]);

            return redirect()->route('order.detail', $order->order_number)
                ->with('success', 'Bukti transfer berhasil diunggah! Tim Batik Gendis Ayu akan segera memverifikasi pembayaran Anda.');
        }

        return back()->with('error', 'Gagal mengunggah bukti transfer.');
    }

    public function detail(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product', 'items.variant'])
            ->firstOrFail();

        return view('orders.detail', compact('order'));
    }

    public function invoice(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product', 'items.variant'])
            ->firstOrFail();

        return view('orders.invoice', compact('order'));
    }
}
