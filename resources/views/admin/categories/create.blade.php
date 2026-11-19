@extends('layouts.admin')
@section('page_title', 'Tambah Kategori Baru')
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.categories.index') }}" class="text-xs text-batik-gold hover:underline font-semibold mb-4 inline-block"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali</a>
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4 text-xs">
            @csrf
            <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Kategori <span class="text-rose-500">*</span></label><input type="text" name="name" value="{{ old('name') }}" required class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none" placeholder="Contoh: Kemeja Batik Pria"></div>
            <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Deskripsi</label><textarea name="description" rows="3" class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none" placeholder="Deskripsi singkat kategori">{{ old('description') }}</textarea></div>
            <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">URL Gambar</label><input type="text" name="image" value="{{ old('image') }}" class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none" placeholder="https://..."></div>
            <div class="pt-2"><button type="submit" class="inline-flex items-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold py-3 px-6 rounded-xl text-xs shadow-sm transition"><i class="fa-solid fa-floppy-disk"></i> Simpan Kategori</button></div>
        </form>
    </div>
</div>
@endsection
