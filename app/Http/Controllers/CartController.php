<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        $totalWeight = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $totalWeight += ($item['weight'] ?? 350) * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'subtotal', 'totalWeight'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $variant = ProductVariant::where('id', $request->variant_id)
            ->where('product_id', $product->id)
            ->firstOrFail();

        $quantity = (int) $request->quantity;

        // Check stock availability
        if ($variant->stock <= 0) {
            return back()->with('error', 'Mohon maaf, ukuran ' . $variant->size . ' untuk produk ini sedang habis.');
        }

        $cart = session()->get('cart', []);
        $cartKey = $product->id . '_' . $variant->id;

        $existingQty = isset($cart[$cartKey]) ? $cart[$cartKey]['quantity'] : 0;
        $newQty = $existingQty + $quantity;

        if ($newQty > $variant->stock) {
            return back()->with('error', "Stok ukuran {$variant->size} hanya tersisa {$variant->stock} pcs. Anda sudah memiliki {$existingQty} di keranjang.");
        }

        $cart[$cartKey] = [
            'product_id' => $product->id,
            'variant_id' => $variant->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'sku' => $product->sku,
            'size' => $variant->size,
            'price' => (float) $product->price,
            'buy_price' => (float) $product->buy_price,
            'weight' => (int) $product->weight,
            'image' => $product->image,
            'quantity' => $newQty,
            'max_stock' => $variant->stock,
        ];

        session()->put('cart', $cart);

        if ($request->has('buy_now')) {
            return redirect()->route('checkout.index');
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang belanja Anda.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        $key = $request->cart_key;

        if (isset($cart[$key])) {
            $variant = ProductVariant::find($cart[$key]['variant_id']);
            $maxStock = $variant ? $variant->stock : $cart[$key]['max_stock'];

            $qty = (int) $request->quantity;
            if ($qty > $maxStock) {
                return back()->with('error', "Jumlah melebihi stok yang tersedia (maksimal {$maxStock} pcs).");
            }

            $cart[$key]['quantity'] = $qty;
            session()->put('cart', $cart);

            return back()->with('success', 'Jumlah pesanan berhasil diperbarui.');
        }

        return back()->with('error', 'Item tidak ditemukan di keranjang.');
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        $key = $request->cart_key;

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
            return back()->with('success', 'Produk telah dihapus dari keranjang.');
        }

        return back()->with('error', 'Item tidak ditemukan.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Keranjang belanja telah dikosongkan.');
    }
}
