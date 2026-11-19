@extends('layouts.admin')
@section('page_title', 'Daftar Produk Batik')
@section('content')
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <form method="GET" action="{{ route('admin.products.index') }}" class="flex items-center gap-3 flex-wrap">
        <div class="relative"><input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk / SKU..." class="text-xs pl-9 pr-3 py-2.5 border border-gray-200 rounded-xl w-56 focus:border-batik-gold outline-none"><i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-xs"></i></div>
        <select name="category_id" onchange="this.form.submit()" class="text-xs py-2.5 px-3 border border-gray-200 rounded-xl bg-white focus:border-batik-gold outline-none"><option value="">Semua Kategori</option>@foreach($categories as $c)<option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select>
        <button type="submit" class="text-xs bg-gray-100 hover:bg-gray-200 px-4 py-2.5 rounded-xl font-semibold">Filter</button>
    </form>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold px-5 py-2.5 rounded-xl text-xs shadow-sm transition"><i class="fa-solid fa-plus"></i> Tambah Produk</a>
</div>
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
    <table class="w-full text-xs text-left min-w-[900px]">
        <thead><tr class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase tracking-wider"><th class="p-4">Foto</th><th class="p-4">SKU</th><th class="p-4">Nama Produk</th><th class="p-4">Kategori</th><th class="p-4">Motif</th><th class="p-4 text-right">Harga Jual</th><th class="p-4 text-center">Total Stok</th><th class="p-4 text-center">Status</th><th class="p-4 text-right">Aksi</th></tr></thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($products as $p)
            <tr class="hover:bg-gray-50">
                <td class="p-4"><div class="w-12 h-14 rounded-lg overflow-hidden bg-gray-100 border"><img src="{{ $p->image ?: 'https://via.placeholder.com/100' }}" class="w-full h-full object-cover"></div></td>
                <td class="p-4 font-mono text-gray-600">{{ $p->sku }}</td>
                <td class="p-4 font-semibold text-gray-800 max-w-[200px] truncate">{{ $p->name }}</td>
                <td class="p-4 text-gray-600">{{ $p->category->name }}</td>
                <td class="p-4 text-gray-600">{{ $p->motif ?? '-' }}</td>
                <td class="p-4 text-right font-bold text-amber-900">{{ $p->formatted_price }}</td>
                <td class="p-4 text-center"><span class="font-bold px-2 py-0.5 rounded-full text-[11px] border {{ $p->stock_status === 'in_stock' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($p->stock_status === 'low_stock' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">{{ $p->total_stock }} pcs</span></td>
                <td class="p-4 text-center">@if($p->is_active)<span class="text-emerald-600 text-[10px] font-bold">Aktif</span>@else<span class="text-gray-400 text-[10px]">Nonaktif</span>@endif</td>
                <td class="p-4 text-right space-x-2">
                    <a href="{{ route('admin.products.edit', $p) }}" class="text-blue-600 hover:text-blue-800 font-semibold"><i class="fa-solid fa-pen-to-square"></i></a>
                    <form method="POST" action="{{ route('admin.products.destroy', $p) }}" class="inline" onsubmit="return confirm('Hapus produk ini beserta seluruh variannya?')">@csrf @method('DELETE')<button class="text-rose-600 hover:text-rose-800 font-semibold"><i class="fa-solid fa-trash-can"></i></button></form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $products->links() }}</div>
@endsection
