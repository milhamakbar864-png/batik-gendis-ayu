@extends('layouts.admin')

@section('page_title', 'Penerimaan Barang Masuk (Restock Persediaan)')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.inventory.index') }}" class="text-xs text-batik-gold hover:underline font-semibold inline-flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Monitoring Stok
        </a>
        <a href="{{ route('admin.inventory.movements') }}" class="text-xs text-gray-500 hover:text-batik-gold font-semibold">
            Lihat Riwayat Mutasi &rarr;
        </a>
    </div>

    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm"
         x-data="{
            products: {{ $products->toJson() }},
            selectedProductId: '',
            selectedVariantId: '',
            variants: [],
            unitCost: 0,
            onProductChange() {
                const prod = this.products.find(p => p.id == this.selectedProductId);
                if (prod) {
                    this.variants = prod.variants || [];
                    this.unitCost = prod.buy_price || 0;
                    this.selectedVariantId = this.variants.length > 0 ? this.variants[0].id : '';
                } else {
                    this.variants = [];
                    this.selectedVariantId = '';
                    this.unitCost = 0;
                }
            }
         }">

        <div class="border-b border-gray-100 pb-4 mb-6">
            <h2 class="font-serif text-xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-arrow-down-long text-emerald-600"></i>
                <span>Formulir Penerimaan Stok Masuk (Stock-In)</span>
            </h2>
            <p class="text-xs text-gray-500 mt-1">
                Catat penerimaan produk batik dari pengrajin / supplier rekanan. Penambahan stok otomatis masuk ke kartu stok (Inventory Movement).
            </p>
        </div>

        <form method="POST" action="{{ route('admin.inventory.storeStockIn') }}" class="space-y-5 text-xs">
            @csrf

            <!-- Product Selection -->
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Pilih Produk Batik <span class="text-rose-500">*</span></label>
                <select name="product_id" x-model="selectedProductId" @change="onProductChange()" required
                        class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none bg-white">
                    <option value="">-- Pilih Produk Batik --</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->sku }} - {{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Variant Size Selection -->
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Varian Ukuran <span class="text-rose-500">*</span></label>
                <select name="variant_id" x-model="selectedVariantId" required
                        class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none bg-white">
                    <option value="">-- Pilih Ukuran --</option>
                    <template x-for="v in variants" :key="v.id">
                        <option :value="v.id" x-text="v.size + ' (Stok saat ini: ' + v.stock + ' pcs)'"></option>
                    </template>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Quantity -->
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Jumlah Masuk (Pcs) <span class="text-rose-500">*</span></label>
                    <input type="number" name="quantity" min="1" required
                           class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none" placeholder="Contoh: 10">
                </div>

                <!-- Unit Cost -->
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Biaya Beli / HPP Satuan (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="unit_cost" x-model="unitCost" min="0" required
                           class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Reference Number -->
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">No. Faktur / Surat Jalan <span class="text-rose-500">*</span></label>
                    <input type="text" name="reference_number" required value="SJ-IN-{{ date('Ymd-Hi') }}"
                           class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none font-mono">
                </div>

                <!-- Supplier Name -->
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Pengrajin / Supplier</label>
                    <input type="text" name="supplier_name"
                           class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none"
                           placeholder="Contoh: Paguyuban Batik Imogiri">
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Catatan Tambahan</label>
                <textarea name="notes" rows="3"
                          class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none"
                          placeholder="Keterangan pengiriman, nomor batch, atau kondisi kain..."></textarea>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.inventory.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold transition">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-sm transition">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan Stok Masuk</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
