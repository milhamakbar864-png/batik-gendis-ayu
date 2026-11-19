<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong. Silakan pilih produk batik terlebih dahulu.');
        }

        $subtotal = 0;
        $totalWeight = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $totalWeight += ($item['weight'] ?? 350) * $item['quantity'];
        }

        $bankAccounts = BankAccount::where('is_active', true)->get();
        $user = Auth::user();

        // Daftar opsi kurir & estimasi tarif dasar
        $couriers = [
            'JNE Regular' => 18000,
            'J&T Express EZ' => 20000,
            'SiCepat REG' => 19000,
            'POS Kilat Khusus' => 17000,
        ];

        return view('checkout.index', compact(
            'cart',
            'subtotal',
            'totalWeight',
            'bankAccounts',
            'user',
            'couriers'
        ));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:25',
            'shipping_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'courier' => 'required|string',
            'payment_method' => 'required|string',
            'customer_notes' => 'nullable|string|max:500',
        ], [
            'customer_name.required' => 'Nama lengkap penerima wajib diisi.',
            'customer_email.required' => 'Alamat email wajib diisi untuk bukti pesanan.',
            'customer_phone.required' => 'Nomor telepon / WhatsApp wajib diisi.',
            'shipping_address.required' => 'Alamat pengiriman lengkap wajib diisi.',
            'city.required' => 'Kota/Kabupaten wajib diisi.',
            'province.required' => 'Provinsi wajib diisi.',
            'courier.required' => 'Silakan pilih jasa kurir pengiriman.',
            'payment_method.required' => 'Silakan pilih metode transfer pembayaran.',
        ]);

        // Hitung Subtotal & Ongkir
        $subtotal = 0;
        $totalWeight = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $totalWeight += ($item['weight'] ?? 350) * $item['quantity'];
        }

        // Hitung ongkir berdasarkan berat (dibulatkan ke atas per kg)
        $weightInKg = max(1, ceil($totalWeight / 1000));
        $courierRates = [
            'JNE Regular' => 18000,
            'J&T Express EZ' => 20000,
            'SiCepat REG' => 19000,
            'POS Kilat Khusus' => 17000,
        ];
        $baseRate = $courierRates[$validated['courier']] ?? 20000;
        $shippingCost = $baseRate * $weightInKg;
        $totalAmount = $subtotal + $shippingCost;

        try {
            $order = DB::transaction(function () use ($validated, $cart, $subtotal, $shippingCost, $totalAmount) {
                // 1. Validasi ulang stok sebelum transaksi commit (Pencegahan race condition)
                foreach ($cart as $item) {
                    $variant = ProductVariant::lockForUpdate()->find($item['variant_id']);
                    if (!$variant || $variant->stock < $item['quantity']) {
                        throw new \Exception("Stok produk '{$item['name']}' ukuran '{$item['size']}' tidak mencukupi (sisa: " . ($variant ? $variant->stock : 0) . " pcs).");
                    }
                }

                // 2. Generate No Pesanan Unik: ORD-BGA-YYYYMM-XXXX
                $orderNumber = 'ORD-BGA-' . date('Ym') . '-' . strtoupper(Str::random(5));

                // 3. Simpan Data Order
                $order = Order::create([
                    'order_number' => $orderNumber,
                    'user_id' => Auth::id(),
                    'customer_name' => $validated['customer_name'],
                    'customer_email' => $validated['customer_email'],
                    'customer_phone' => $validated['customer_phone'],
                    'shipping_address' => $validated['shipping_address'],
                    'city' => $validated['city'],
                    'province' => $validated['province'],
                    'postal_code' => $validated['postal_code'] ?? null,
                    'courier' => $validated['courier'],
                    'subtotal' => $subtotal,
                    'shipping_cost' => $shippingCost,
                    'total_amount' => $totalAmount,
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => 'unpaid',
                    'order_status' => 'pending',
                    'customer_notes' => $validated['customer_notes'] ?? null,
                ]);

                // 4. Simpan Order Items & Kurangi Persediaan (Mutasi Stok Otomatis)
                foreach ($cart as $item) {
                    $variant = ProductVariant::find($item['variant_id']);
                    $stockBefore = $variant->stock;
                    $stockAfter = $stockBefore - $item['quantity'];

                    // Update stok varian
                    $variant->update(['stock' => $stockAfter]);

                    // Simpan item pesanan
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'variant_id' => $item['variant_id'],
                        'product_name' => $item['name'],
                        'variant_size' => $item['size'],
                        'price' => $item['price'],
                        'buy_price' => $item['buy_price'] ?? 0,
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['price'] * $item['quantity'],
                    ]);

                    // Catat ke Kartu Stok / Jurnal Persediaan (Inventory Movement)
                    InventoryMovement::create([
                        'product_id' => $item['product_id'],
                        'variant_id' => $item['variant_id'],
                        'type' => 'sale',
                        'reference_type' => 'order',
                        'reference_number' => $orderNumber,
                        'quantity' => -$item['quantity'],
                        'stock_before' => $stockBefore,
                        'stock_after' => $stockAfter,
                        'unit_cost' => $item['buy_price'] ?? 0,
                        'notes' => 'Penjualan online pesanan ' . $orderNumber,
                        'created_by' => Auth::id() ?? null,
                    ]);
                }

                return $order;
            });

            // Kosongkan keranjang belanja
            session()->forget('cart');

            return redirect()->route('order.payment', $order->order_number)
                ->with('success', 'Pesanan Anda berhasil dibuat! Silakan selesaikan pembayaran sesuai rincian rekening.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage())->withInput();
        }
    }
}
