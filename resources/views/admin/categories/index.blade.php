@extends('layouts.admin')
@section('page_title', 'Kelola Kategori Batik')
@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-xs text-gray-500">Total {{ $categories->total() }} kategori terdaftar</p>
    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold px-5 py-2.5 rounded-xl text-xs shadow-sm transition"><i class="fa-solid fa-plus"></i> Tambah Kategori</a>
</div>
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-xs text-left">
        <thead><tr class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase tracking-wider"><th class="p-4">ID</th><th class="p-4">Nama</th><th class="p-4">Slug</th><th class="p-4 text-center">Jumlah Produk</th><th class="p-4 text-right">Aksi</th></tr></thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($categories as $cat)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-4 text-gray-400">{{ $cat->id }}</td>
                <td class="p-4 font-semibold text-gray-800">{{ $cat->name }}</td>
                <td class="p-4 text-gray-500 font-mono">{{ $cat->slug }}</td>
                <td class="p-4 text-center"><span class="bg-amber-50 text-amber-800 font-bold px-2 py-0.5 rounded-full border border-amber-200">{{ $cat->products_count }}</span></td>
                <td class="p-4 text-right space-x-2">
                    <a href="{{ route('admin.categories.edit', $cat) }}" class="text-blue-600 hover:text-blue-800 font-semibold"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" class="inline" onsubmit="return confirm('Yakin hapus kategori ini?')">@csrf @method('DELETE')
                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $categories->links() }}</div>
@endsection
