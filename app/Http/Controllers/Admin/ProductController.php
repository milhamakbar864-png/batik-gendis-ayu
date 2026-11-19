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
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'variants']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('motif', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|max:50|unique:products,sku',
            'name' => 'required|string|max:255',
            'motif' => 'nullable|string|max:100',
            'material' => 'nullable|string|max:100',
            'technique' => 'nullable|string|max:100',
            'buy_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:1',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'required|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'variants' => 'required|array|min:1',
            'variants.*.size' => 'required|string',
            'variants.*.stock' => 'required|integer|min:0',
        ], [
            'sku.unique' => 'Kode SKU produk ini sudah digunakan.',
            'variants.required' => 'Minimal masukkan satu ukuran/varian produk.',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $product = Product::create([
                'category_id' => $validated['category_id'],
                'sku' => strtoupper($validated['sku']),
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name'] . '-' . Str::random(4)),
                'motif' => $validated['motif'] ?? null,
                'material' => $validated['material'] ?? null,
                'technique' => $validated['technique'] ?? null,
                'buy_price' => $validated['buy_price'],
                'price' => $validated['price'],
                'weight' => $validated['weight'],
                'min_stock' => $validated['min_stock'],
                'description' => $validated['description'] ?? null,
                'image' => $validated['image'],
                'is_active' => $request->has('is_active'),
                'is_featured' => $request->has('is_featured'),
            ]);

            foreach ($validated['variants'] as $v) {
                $stock = (int) $v['stock'];
                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => $v['size'],
                    'sku_variant' => $product->sku . '-' . Str::slug($v['size']),
                    'stock' => $stock,
                ]);

                if ($stock > 0) {
                    InventoryMovement::create([
                        'product_id' => $product->id,
                        'variant_id' => $variant->id,
                        'type' => 'in',
                        'reference_type' => 'stock_initial',
                        'reference_number' => 'INIT-' . $product->sku,
                        'quantity' => $stock,
                        'stock_before' => 0,
                        'stock_after' => $stock,
                        'unit_cost' => $product->buy_price,
                        'notes' => 'Pencatatan persediaan stok awal produk',
                        'created_by' => Auth::id(),
                    ]);
                }
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Produk batik berhasil ditambahkan ke katalog dan persediaan.');
    }

    public function edit(Product $product)
    {
        $product->load(['category', 'variants']);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'motif' => 'nullable|string|max:100',
            'material' => 'nullable|string|max:100',
            'technique' => 'nullable|string|max:100',
            'buy_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:1',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'required|string',
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|exists:product_variants,id',
            'variants.*.size' => 'required|string',
            'variants.*.stock' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($validated, $request, $product) {
            $product->update([
                'category_id' => $validated['category_id'],
                'sku' => strtoupper($validated['sku']),
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'motif' => $validated['motif'] ?? null,
                'material' => $validated['material'] ?? null,
                'technique' => $validated['technique'] ?? null,
                'buy_price' => $validated['buy_price'],
                'price' => $validated['price'],
                'weight' => $validated['weight'],
                'min_stock' => $validated['min_stock'],
                'description' => $validated['description'] ?? null,
                'image' => $validated['image'],
                'is_active' => $request->has('is_active'),
                'is_featured' => $request->has('is_featured'),
            ]);

            // Handle variants
            if (!empty($validated['variants'])) {
                $existingIds = [];
                foreach ($validated['variants'] as $v) {
                    if (!empty($v['id'])) {
                        $variant = ProductVariant::find($v['id']);
                        if ($variant) {
                            $oldStock = $variant->stock;
                            $newStock = (int) $v['stock'];
                            $diff = $newStock - $oldStock;

                            $variant->update([
                                'size' => $v['size'],
                                'stock' => $newStock,
                            ]);
                            $existingIds[] = $variant->id;

                            if ($diff != 0) {
                                InventoryMovement::create([
                                    'product_id' => $product->id,
                                    'variant_id' => $variant->id,
                                    'type' => 'adjustment',
                                    'reference_type' => 'admin_edit',
                                    'reference_number' => 'ADJ-EDIT-' . date('YmdHi'),
                                    'quantity' => $diff,
                                    'stock_before' => $oldStock,
                                    'stock_after' => $newStock,
                                    'unit_cost' => $product->buy_price,
                                    'notes' => 'Koreksi stok melalui edit data varian produk',
                                    'created_by' => Auth::id(),
                                ]);
                            }
                        }
                    } else {
                        // New variant
                        $variant = ProductVariant::create([
                            'product_id' => $product->id,
                            'size' => $v['size'],
                            'sku_variant' => $product->sku . '-' . Str::slug($v['size']),
                            'stock' => (int) $v['stock'],
                        ]);
                        $existingIds[] = $variant->id;

                        if ((int) $v['stock'] > 0) {
                            InventoryMovement::create([
                                'product_id' => $product->id,
                                'variant_id' => $variant->id,
                                'type' => 'in',
                                'reference_type' => 'new_variant',
                                'reference_number' => 'INIT-VAR-' . $product->sku,
                                'quantity' => (int) $v['stock'],
                                'stock_before' => 0,
                                'stock_after' => (int) $v['stock'],
                                'unit_cost' => $product->buy_price,
                                'notes' => 'Stok awal varian baru',
                                'created_by' => Auth::id(),
                            ]);
                        }
                    }
                }
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Data produk dan persediaan berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk telah dihapus dari sistem.');
    }
}
