@extends('layouts.admin')

@section('page_title', 'Pengeluaran Stok (Retur / Rusak / Cacat)')

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
            currentStock: 0,
            onProductChange() {
                const prod = this.products.find(p => p.id == this.selectedProductId);
                if (prod) {
                    this.variants = prod.variants || [];
                    this.selectedVariantId = this.variants.length > 0 ? this.variants[0].id : '';
                    this.updateCurrentStock();
                } else {
                    this.variants = [];
                    this.selectedVariantId = '';
                    this.currentStock = 0;
                }
            },
            updateCurrentStock() {
                const v = this.variants.find(item => item.id == this.selectedVariantId);
                this.currentStock = v ? v.stock : 0;
            }
         }">

        <div class="border-b border-gray-100 pb-4 mb-6">
            <h2 class="font-serif text-xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-arrow-up-long text-rose-600"></i>
                <span>Formulir Pengeluaran Stok (Stock-Out / Koreksi)</span>
            </h2>
            <p class="text-xs text-gray-500 mt-1">
                Catat pengurangan persediaan akibat cacat produksi, kain sobek/luntur, retur ke pengrajin, atau selisih stok opname fisik.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.inventory.storeStockOut') }}" class="space-y-5 text-xs">
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
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block font-bold text-gray-700 uppercase tracking-wider">Varian Ukuran <span class="text-rose-500">*</span></label>
                    <span class="text-xs font-semibold text-gray-500" x-show="selectedVariantId">
                        Stok Tersedia: <strong class="text-gray-800" x-text="currentStock + ' pcs'"></strong>
                    </span>
                </div>
                <select name="variant_id" x-model="selectedVariantId" @change="updateCurrentStock()" required
                        class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none bg-white">
                    <option value="">-- Pilih Ukuran --</option>
                    <template x-for="v in variants" :key="v.id">
                        <option :value="v.id" x-text="v.size + ' (Stok: ' + v.stock + ' pcs)'"></option>
                    </template>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Reason Type -->
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Alasan Pengeluaran <span class="text-rose-500">*</span></label>
                    <select name="reason_type" required
                            class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none bg-white">
                        <option value="damage">Barang Rusak / Cacat Jahitan / Pewarnaan Luntur</option>
                        <option value="return">Retur ke Pengrajin / Supplier</option>
                        <option value="adjustment_minus">Penyesuaian Selisih Stok Opname</option>
                    </select>
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Jumlah Keluar (Pcs) <span class="text-rose-500">*</span></label>
                    <input type="number" name="quantity" min="1" :max="currentStock" required
                           class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none" placeholder="Contoh: 1">
                </div>
            </div>

            <!-- Reference Number -->
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nomor Referensi Berita Acara</label>
                <input type="text" name="reference_number" value="BA-OUT-{{ date('Ymd-Hi') }}"
                       class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none font-mono">
            </div>

            <!-- Notes -->
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Keterangan Rinci Penyebab <span class="text-rose-500">*</span></label>
                <textarea name="notes" rows="3" required
                          class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none"
                          placeholder="Jelaskan kondisi kerusakan fisik, letak cacat, atau alasan retur secara lengkap..."></textarea>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.inventory.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold transition">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-sm transition">
                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                    <span>Simpan Pengeluaran Stok</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
