@extends('layouts.admin')
@section('page_title', 'Tambah Produk Batik Baru')
@section('content')
<a href="{{ route('admin.products.index') }}" class="text-xs text-batik-gold hover:underline font-semibold mb-4 inline-block"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali</a>
<form method="POST" action="{{ route('admin.products.store') }}" x-data="{ variants: [{ size: '', stock: 0 }] }">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4 text-xs">
                <h3 class="font-bold text-sm text-gray-900 border-b pb-3"><i class="fa-solid fa-shirt text-batik-gold mr-2"></i>Informasi Produk</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Kategori *</label><select name="category_id" required class="w-full text-sm p-3 border rounded-xl focus:border-batik-gold outline-none"><option value="">-- Pilih --</option>@foreach($categories as $c)<option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
                    <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Kode SKU *</label><input type="text" name="sku" value="{{ old('sku') }}" required class="w-full text-sm p-3 border rounded-xl focus:border-batik-gold outline-none uppercase" placeholder="BGA-KMJ-003"></div>
                </div>
                <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Produk *</label><input type="text" name="name" value="{{ old('name') }}" required class="w-full text-sm p-3 border rounded-xl focus:border-batik-gold outline-none"></div>
                <div class="grid grid-cols-3 gap-4">
                    <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Motif</label><input type="text" name="motif" value="{{ old('motif') }}" class="w-full text-sm p-3 border rounded-xl focus:border-batik-gold outline-none" placeholder="Parang Kusumo"></div>
                    <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Bahan Kain</label><input type="text" name="material" value="{{ old('material') }}" class="w-full text-sm p-3 border rounded-xl focus:border-batik-gold outline-none" placeholder="Katun Primisima"></div>
                    <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Teknik</label><input type="text" name="technique" value="{{ old('technique') }}" class="w-full text-sm p-3 border rounded-xl focus:border-batik-gold outline-none" placeholder="Batik Cap"></div>
                </div>
                <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi Produk</label><textarea name="description" rows="4" class="w-full text-sm p-3 border rounded-xl focus:border-batik-gold outline-none">{{ old('description') }}</textarea></div>
                <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">URL Gambar Produk *</label><input type="text" name="image" value="{{ old('image') }}" required class="w-full text-sm p-3 border rounded-xl focus:border-batik-gold outline-none" placeholder="https://..."></div>
            </div>

            <!-- Variants -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4 text-xs">
                <div class="flex items-center justify-between border-b pb-3"><h3 class="font-bold text-sm text-gray-900"><i class="fa-solid fa-layer-group text-batik-gold mr-2"></i>Varian Ukuran & Stok Awal</h3><button type="button" @click="variants.push({size:'',stock:0})" class="text-xs bg-amber-50 text-amber-800 px-3 py-1.5 rounded-lg font-bold border border-amber-200 hover:bg-amber-100"><i class="fa-solid fa-plus mr-1"></i> Tambah Varian</button></div>
                <template x-for="(v, i) in variants" :key="i">
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border">
                        <div class="flex-1"><label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Ukuran</label><input type="text" :name="'variants['+i+'][size]'" x-model="v.size" required class="w-full text-sm p-2 border rounded-lg focus:border-batik-gold outline-none" placeholder="M / L / XL"></div>
                        <div class="w-28"><label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Stok Awal</label><input type="number" :name="'variants['+i+'][stock]'" x-model.number="v.stock" min="0" required class="w-full text-sm p-2 border rounded-lg focus:border-batik-gold outline-none"></div>
                        <button type="button" @click="if(variants.length > 1) variants.splice(i, 1)" class="text-rose-500 hover:text-rose-700 mt-5 p-1" x-show="variants.length > 1"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4 text-xs">
                <h3 class="font-bold text-sm text-gray-900 border-b pb-3"><i class="fa-solid fa-tag text-batik-gold mr-2"></i>Harga & Stok</h3>
                <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Harga Beli / HPP (Rp) *</label><input type="number" name="buy_price" value="{{ old('buy_price', 0) }}" required min="0" class="w-full text-sm p-3 border rounded-xl focus:border-batik-gold outline-none"></div>
                <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Harga Jual (Rp) *</label><input type="number" name="price" value="{{ old('price', 0) }}" required min="0" class="w-full text-sm p-3 border rounded-xl focus:border-batik-gold outline-none"></div>
                <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Berat (gram) *</label><input type="number" name="weight" value="{{ old('weight', 350) }}" required min="1" class="w-full text-sm p-3 border rounded-xl focus:border-batik-gold outline-none"></div>
                <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Safety Stock (Min Stok) *</label><input type="number" name="min_stock" value="{{ old('min_stock', 5) }}" required min="0" class="w-full text-sm p-3 border rounded-xl focus:border-batik-gold outline-none"></div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4 text-xs">
                <h3 class="font-bold text-sm text-gray-900 border-b pb-3">Pengaturan</h3>
                <label class="flex items-center gap-3 cursor-pointer"><input type="checkbox" name="is_active" value="1" checked class="text-amber-600 rounded focus:ring-amber-500"><span class="font-semibold text-gray-700">Produk Aktif (Tampil di Katalog)</span></label>
                <label class="flex items-center gap-3 cursor-pointer"><input type="checkbox" name="is_featured" value="1" class="text-amber-600 rounded focus:ring-amber-500"><span class="font-semibold text-gray-700">Produk Unggulan (Featured)</span></label>
            </div>
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold py-3.5 rounded-xl shadow-md transition text-xs uppercase tracking-wider"><i class="fa-solid fa-floppy-disk"></i> Simpan Produk & Stok</button>
        </div>
    </div>
</form>
@endsection
