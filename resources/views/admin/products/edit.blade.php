@extends('layouts.admin')

@section('page_title', 'Edit Produk: ' . $product->name)

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 font-serif">Edit Produk</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui data produk <span class="font-semibold text-batik-brown">{{ $product->name }}</span></p>
        </div>
        <a href="{{ route('admin.products.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-gray-800 bg-white border border-gray-300 px-4 py-2.5 rounded-xl shadow-sm transition hover:shadow-md">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar Produk
        </a>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
          x-data="productEditForm()" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Informasi Umum --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-700 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-batik-gold"></i>
                    Informasi Umum Produk
                </h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Nama Produk --}}
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Produk <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition"
                           placeholder="Contoh: Batik Tulis Mega Mendung">
                    @error('name')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SKU --}}
                <div>
                    <label for="sku" class="block text-sm font-semibold text-gray-700 mb-1.5">SKU (Kode Produk) <span class="text-rose-500">*</span></label>
                    <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition font-mono"
                           placeholder="BTK-001">
                    @error('sku')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori <span class="text-rose-500">*</span></label>
                    <select name="category_id" id="category_id" required
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Motif --}}
                <div>
                    <label for="motif" class="block text-sm font-semibold text-gray-700 mb-1.5">Motif Batik</label>
                    <input type="text" name="motif" id="motif" value="{{ old('motif', $product->motif) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition"
                           placeholder="Contoh: Mega Mendung, Parang Rusak">
                    @error('motif')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Material --}}
                <div>
                    <label for="material" class="block text-sm font-semibold text-gray-700 mb-1.5">Bahan / Material</label>
                    <input type="text" name="material" id="material" value="{{ old('material', $product->material) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition"
                           placeholder="Contoh: Katun Primisima, Sutra">
                    @error('material')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Teknik --}}
                <div>
                    <label for="technique" class="block text-sm font-semibold text-gray-700 mb-1.5">Teknik Pembuatan</label>
                    <input type="text" name="technique" id="technique" value="{{ old('technique', $product->technique) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition"
                           placeholder="Contoh: Tulis, Cap, Kombinasi">
                    @error('technique')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Berat --}}
                <div>
                    <label for="weight" class="block text-sm font-semibold text-gray-700 mb-1.5">Berat (gram) <span class="text-rose-500">*</span></label>
                    <input type="number" name="weight" id="weight" value="{{ old('weight', $product->weight) }}" required min="1"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition"
                           placeholder="250">
                    @error('weight')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Harga & Stok --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-700 flex items-center gap-2">
                    <i class="fa-solid fa-money-bill-wave text-batik-gold"></i>
                    Harga & Pengaturan Stok
                </h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-5">
                {{-- Harga Beli --}}
                <div>
                    <label for="buy_price" class="block text-sm font-semibold text-gray-700 mb-1.5">Harga Beli (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="buy_price" id="buy_price" value="{{ old('buy_price', $product->buy_price) }}" required min="0"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition"
                           placeholder="150000">
                    @error('buy_price')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga Jual --}}
                <div>
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-1.5">Harga Jual (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required min="0"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition"
                           placeholder="250000">
                    @error('price')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Safety Stock --}}
                <div>
                    <label for="min_stock" class="block text-sm font-semibold text-gray-700 mb-1.5">Safety Stock (Min. Stok) <span class="text-rose-500">*</span></label>
                    <input type="number" name="min_stock" id="min_stock" value="{{ old('min_stock', $product->min_stock) }}" required min="0"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition"
                           placeholder="5">
                    <p class="text-xs text-gray-400 mt-1">Peringatan muncul jika stok ≤ nilai ini</p>
                    @error('min_stock')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Deskripsi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-700 flex items-center gap-2">
                    <i class="fa-solid fa-align-left text-batik-gold"></i>
                    Deskripsi Produk
                </h3>
            </div>
            <div class="p-6">
                <textarea name="description" id="description" rows="5"
                          class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition resize-y"
                          placeholder="Tuliskan deskripsi lengkap produk batik...">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Gambar Produk --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-700 flex items-center gap-2">
                    <i class="fa-solid fa-image text-batik-gold"></i>
                    Gambar Produk
                </h3>
            </div>
            <div class="p-6">
                @if($product->image)
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 mb-2">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                             class="w-32 h-32 object-cover rounded-xl border border-gray-200 shadow-sm">
                    </div>
                @endif
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-1.5">Ganti Gambar (Opsional)</label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-batik-gold/10 file:text-batik-brown hover:file:bg-batik-gold/20">
                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WebP. Maksimal 2MB. Kosongkan jika tidak ingin mengganti.</p>
                @error('image')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Status Produk --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-700 flex items-center gap-2">
                    <i class="fa-solid fa-toggle-on text-batik-gold"></i>
                    Status & Tampilan
                </h3>
            </div>
            <div class="p-6 flex flex-wrap gap-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-gray-300 text-batik-gold focus:ring-batik-gold/40">
                    <span class="text-sm font-medium text-gray-700">Produk Aktif (ditampilkan di katalog)</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-gray-300 text-batik-gold focus:ring-batik-gold/40">
                    <span class="text-sm font-medium text-gray-700">Produk Unggulan (tampil di halaman utama)</span>
                </label>
            </div>
        </div>

        {{-- Varian Ukuran --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-gray-700 flex items-center gap-2">
                    <i class="fa-solid fa-ruler text-batik-gold"></i>
                    Varian Ukuran & Stok
                </h3>
                <button type="button" @click="addVariant()"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold bg-batik-gold text-white px-3 py-1.5 rounded-lg hover:bg-batik-goldHover transition shadow-sm">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Varian
                </button>
            </div>
            <div class="p-6">
                <template x-if="variants.length === 0">
                    <div class="text-center py-8 text-gray-400">
                        <i class="fa-solid fa-box-open text-4xl mb-3"></i>
                        <p class="text-sm">Belum ada varian. Klik "Tambah Varian" untuk menambahkan ukuran.</p>
                    </div>
                </template>

                <div class="space-y-3">
                    <template x-for="(variant, index) in variants" :key="index">
                        <div class="flex flex-col sm:flex-row items-start sm:items-end gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            {{-- Hidden ID for existing variants --}}
                            <template x-if="variant.id">
                                <input type="hidden" :name="'variants[' + index + '][id]'" :value="variant.id">
                            </template>

                            {{-- Ukuran --}}
                            <div class="flex-1 w-full sm:w-auto">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Ukuran <span class="text-rose-500">*</span></label>
                                <input type="text" :name="'variants[' + index + '][size]'" x-model="variant.size" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition"
                                       placeholder="Contoh: M, L, XL, All Size">
                            </div>

                            {{-- Stok --}}
                            <div class="w-full sm:w-32">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Stok <span class="text-rose-500">*</span></label>
                                <input type="number" :name="'variants[' + index + '][stock]'" x-model="variant.stock" required min="0"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition"
                                       placeholder="0">
                            </div>

                            {{-- Hapus --}}
                            <div class="flex-shrink-0">
                                <button type="button" @click="removeVariant(index)"
                                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 border border-rose-200 px-3 py-2 rounded-lg transition">
                                    <i class="fa-solid fa-trash-can"></i>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                @error('variants')
                    <p class="text-xs text-rose-500 mt-2">{{ $message }}</p>
                @enderror
                @error('variants.*')
                    <p class="text-xs text-rose-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-2 pb-6">
            <a href="{{ route('admin.products.index') }}"
               class="inline-flex items-center justify-center gap-2 text-sm font-semibold text-gray-600 hover:text-gray-800 bg-white border border-gray-300 px-6 py-3 rounded-xl shadow-sm transition hover:shadow-md">
                <i class="fa-solid fa-xmark"></i>
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 text-sm font-bold text-white bg-batik-gold hover:bg-batik-goldHover px-8 py-3 rounded-xl shadow-lg transition hover:shadow-xl">
                <i class="fa-solid fa-floppy-disk"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function productEditForm() {
        return {
            variants: @json(old('variants', $product->variants->map(function($v) {
                return ['id' => $v->id, 'size' => $v->size, 'stock' => $v->stock];
            })->toArray())),

            addVariant() {
                this.variants.push({ id: null, size: '', stock: 0 });
            },

            removeVariant(index) {
                this.variants.splice(index, 1);
            }
        }
    }
</script>
@endpush
@endsection
