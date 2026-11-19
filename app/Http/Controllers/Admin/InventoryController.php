<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Tampilan Ringkasan Persediaan & Monitoring Status Stok
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'variants']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $allProducts = $query->get();

        // Filter status stok jika dipilih
        if ($request->filled('status')) {
            if ($request->status === 'low') {
                $allProducts = $allProducts->filter(fn($p) => $p->total_stock > 0 && $p->total_stock <= $p->min_stock);
            } elseif ($request->status === 'out') {
                $allProducts = $allProducts->filter(fn($p) => $p->total_stock <= 0);
            } elseif ($request->status === 'safe') {
                $allProducts = $allProducts->filter(fn($p) => $p->total_stock > $p->min_stock);
            }
        }

        // Pagination manual sederhana untuk collection
        $page = $request->get('page', 1);
        $perPage = 10;
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $allProducts->forPage($page, $perPage),
            $allProducts->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $categories = Category::all();

        // Statistik Persediaan Keseluruhan
        $totalUnits = ProductVariant::sum('stock');
        $totalAssetValue = Product::with('variants')->get()->sum(function ($p) {
            return $p->variants->sum('stock') * $p->buy_price;
        });

        $criticalCount = Product::with('variants')->get()->filter(function ($p) {
            return $p->total_stock <= $p->min_stock;
        })->count();

        return view('admin.inventory.index', compact(
            'products',
            'categories',
            'totalUnits',
            'totalAssetValue',
            'criticalCount'
        ));
    }

    /**
     * Form Penerimaan Barang Masuk (Restock dari Pengrajin/Supplier)
     */
    public function createStockIn()
    {
        $products = Product::where('is_active', true)->with('variants')->orderBy('name')->get();
        return view('admin.inventory.stock-in', compact('products'));
    }

    /**
     * Proses Simpan Penerimaan Barang Masuk
     */
    public function storeStockIn(Request $request)
    {
        $validated = $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'reference_number' => 'required|string|max:100',
            'supplier_name' => 'nullable|string|max:150',
            'notes' => 'nullable|string|max:500',
        ], [
            'variant_id.required' => 'Pilih varian produk yang akan ditambah stoknya.',
            'quantity.min' => 'Jumlah barang masuk minimal 1 pcs.',
            'reference_number.required' => 'Nomor surat jalan / faktur pembelian wajib diisi.',
        ]);

        DB::transaction(function () use ($validated) {
            $variant = ProductVariant::lockForUpdate()->findOrFail($validated['variant_id']);
            $product = $variant->product;

            $stockBefore = $variant->stock;
            $stockAfter = $stockBefore + (int) $validated['quantity'];

            // Update stok varian
            $variant->update(['stock' => $stockAfter]);

            // Catat di Jurnal Mutasi Persediaan (Inventory Movement)
            InventoryMovement::create([
                'product_id' => $product->id,
                'variant_id' => $variant->id,
                'type' => 'in',
                'reference_type' => 'supplier_purchase',
                'reference_number' => $validated['reference_number'],
                'quantity' => (int) $validated['quantity'],
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'unit_cost' => $validated['unit_cost'],
                'notes' => ($validated['supplier_name'] ? "Supplier/Pengrajin: {$validated['supplier_name']}. " : '') . ($validated['notes'] ?? ''),
                'created_by' => Auth::id(),
            ]);
        });

        return redirect()->route('admin.inventory.movements')
            ->with('success', 'Stok masuk berhasil dicatat. Persediaan telah diperbarui secara real-time.');
    }

    /**
     * Form Pengeluaran Stok / Penyesuaian Barang Cacat / Retur
     */
    public function createStockOut()
    {
        $products = Product::where('is_active', true)->with('variants')->orderBy('name')->get();
        return view('admin.inventory.stock-out', compact('products'));
    }

    /**
     * Proses Simpan Pengeluaran Stok
     */
    public function storeStockOut(Request $request)
    {
        $validated = $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'reason_type' => 'required|string|in:damage,return,adjustment_minus',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'required|string|max:500',
        ], [
            'variant_id.required' => 'Pilih produk dan ukuran yang akan dikeluarkan.',
            'notes.required' => 'Alasan pengeluaran / kerusakan wajib dijelaskan.',
        ]);

        DB::transaction(function () use ($validated) {
            $variant = ProductVariant::lockForUpdate()->findOrFail($validated['variant_id']);
            $product = $variant->product;

            if ($variant->stock < (int) $validated['quantity']) {
                throw new \Exception("Stok tidak mencukupi untuk dikeluarkan. Stok saat ini: {$variant->stock} pcs.");
            }

            $stockBefore = $variant->stock;
            $stockAfter = $stockBefore - (int) $validated['quantity'];

            $variant->update(['stock' => $stockAfter]);

            $reasonLabels = [
                'damage' => 'Barang Rusak / Cacat Produksi',
                'return' => 'Retur ke Pengrajin',
                'adjustment_minus' => 'Selisih Negatif Stok Opname',
            ];

            InventoryMovement::create([
                'product_id' => $product->id,
                'variant_id' => $variant->id,
                'type' => 'out',
                'reference_type' => $validated['reason_type'],
                'reference_number' => $validated['reference_number'] ?: ('OUT-' . date('Ymd-His')),
                'quantity' => - (int) $validated['quantity'],
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'unit_cost' => $product->buy_price,
                'notes' => '[' . ($reasonLabels[$validated['reason_type']] ?? 'Pengeluaran') . '] ' . $validated['notes'],
                'created_by' => Auth::id(),
            ]);
        });

        return redirect()->route('admin.inventory.movements')
            ->with('success', 'Pengurangan persediaan berhasil dicatat.');
    }

    /**
     * Kartu Stok & Jurnal Mutasi Persediaan (Stock Ledger)
     */
    public function movements(Request $request)
    {
        $query = InventoryMovement::with(['product.category', 'variant', 'creator']);

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $movements = $query->latest()->paginate(15)->withQueryString();
        $products = Product::orderBy('name')->get();

        return view('admin.inventory.movements', compact('movements', 'products'));
    }

    /**
     * Peringatan Stok Kritis (Safety Stock & Reorder Point Alerts)
     */
    public function alerts()
    {
        $criticalProducts = Product::with(['category', 'variants'])
            ->get()
            ->filter(function ($p) {
                return $p->total_stock <= $p->min_stock;
            });

        return view('admin.inventory.alerts', compact('criticalProducts'));
    }
}
