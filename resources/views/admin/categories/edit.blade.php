@extends('layouts.admin')
@section('page_title', 'Edit Kategori: ' . $category->name)
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.categories.index') }}" class="text-xs text-batik-gold hover:underline font-semibold mb-4 inline-block"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali</a>
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-4 text-xs">
            @csrf @method('PUT')
            <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Kategori <span class="text-rose-500">*</span></label><input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none"></div>
            <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Deskripsi</label><textarea name="description" rows="3" class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none">{{ old('description', $category->description) }}</textarea></div>
            <div><label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">URL Gambar</label><input type="text" name="image" value="{{ old('image', $category->image) }}" class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none"></div>
            <div class="pt-2"><button type="submit" class="inline-flex items-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold py-3 px-6 rounded-xl text-xs shadow-sm transition"><i class="fa-solid fa-floppy-disk"></i> Perbarui Kategori</button></div>
        </form>
    </div>
</div>
@endsection
