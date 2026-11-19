@extends('layouts.admin')

@section('page_title', 'Laporan Nilai Persediaan Produk Batik')

@section('content')
<div class="space-y-6">
    <!-- Filter & Print Action Bar -->
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.reports.inventory') }}" class="flex items-center gap-3 text-xs">
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Filter Kategori Batik</label>
                <select name="category_id" onchange="this.form.submit()"
                        class="p-2.5 border border-gray-200 rounded-xl focus:border-batik-gold outline-none bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if(request('category_id'))
                <div class="pt-5">
                    <a href="{{ route('admin.reports.inventory') }}" class="text-xs text-rose-600 hover:underline">Reset</a>
                </div>
            @endif
        </form>

        <a href="{{ route('admin.reports.inventory', ['category_id' => request('category_id'), 'print' => 1]) }}" target="_blank"
           class="inline-flex items-center gap-2 bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-200 font-bold text-xs px-4 py-2.5 rounded-xl shadow-sm transition whitespace-nowrap">
            <i class="fa-solid fa-print text-batik-gold"></i>
            <span>Cetak Valuasi Persediaan (PDF)</span>
        </a>
    </div>

    <!-- Inventory Valuation Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-[11px] text-gray-500 block uppercase font-medium">Total Fisik Persediaan</span>
            <span class="font-serif text-2xl font-bold text-gray-900 block mt-1">{{ number_format($totalStockUnits) }} pcs</span>
            <span class="text-[10px] text-gray-400">Seluruh varian ukuran</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-[11px] text-gray-500 block uppercase font-medium">Total Nilai Aset (HPP)</span>
            <span class="font-serif text-2xl font-bold text-amber-900 block mt-1">Rp {{ number_format($totalAssetValue, 0, ',', '.') }}</span>
            <span class="text-[10px] text-gray-400">Modal persediaan saat ini</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-[11px] text-gray-500 block uppercase font-medium">Potensi Nilai Jual Retail</span>
            <span class="font-serif text-2xl font-bold text-blue-900 block mt-1">Rp {{ number_format($totalRetailValue, 0, ',', '.') }}</span>
            <span class="text-[10px] text-gray-400">Berdasarkan harga katalog</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-emerald-200 bg-emerald-50/40 shadow-sm">
            <span class="text-[11px] text-emerald-800 block uppercase font-bold">Potensi Margin Laba Kotor</span>
            <span class="font-serif text-2xl font-bold text-emerald-700 block mt-1">Rp {{ number_format($potentialMargin, 0, ',', '.') }}</span>
            <span class="text-[10px] text-emerald-600 font-semibold">Selisih Retail - HPP</span>
        </div>
    </div>

    <!-- Products Valuation Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
        <table class="w-full text-xs text-left min-w-[950px]">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase tracking-wider">
                    <th class="p-4">SKU</th>
                    <th class="p-4">Nama Produk Batik</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4 text-center">Stok (Pcs)</th>
                    <th class="p-4 text-center">Safety Stock</th>
                    <th class="p-4 text-right">Harga Beli (HPP)</th>
                    <th class="p-4 text-right">Harga Jual</th>
                    <th class="p-4 text-right">Total Nilai Aset</th>
                    <th class="p-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($products as $p)
                    @php
                        $stock = $p->total_stock;
                        $assetVal = $stock * $p->buy_price;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-mono text-gray-600">{{ $p->sku }}</td>
                        <td class="p-4">
                            <span class="font-semibold text-gray-800 block">{{ $p->name }}</span>
                            <span class="text-[10px] text-gray-400">Motif: {{ $p->motif ?? '-' }}</span>
                        </td>
                        <td class="p-4 text-gray-600">{{ $p->category->name }}</td>
                        <td class="p-4 text-center">
                            <strong class="text-sm {{ $stock <= 0 ? 'text-rose-600' : ($stock <= $p->min_stock ? 'text-amber-600' : 'text-gray-900') }}">
                                {{ $stock }}
                            </strong>
                        </td>
                        <td class="p-4 text-center text-gray-500">{{ $p->min_stock }} pcs</td>
                        <td class="p-4 text-right font-mono">{{ $p->formatted_buy_price }}</td>
                        <td class="p-4 text-right font-mono font-semibold">{{ $p->formatted_price }}</td>
                        <td class="p-4 text-right font-mono font-bold text-amber-900">
                            Rp {{ number_format($assetVal, 0, ',', '.') }}
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold border {{ $p->stock_status === 'in_stock' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($p->stock_status === 'low_stock' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                {{ $p->stock_status === 'in_stock' ? 'Aman' : ($p->stock_status === 'low_stock' ? 'Menipis' : 'Habis') }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-amber-50/70 border-t-2 border-amber-200 font-bold text-xs">
                    <td colspan="3" class="p-4 text-right text-gray-800 uppercase">Total Persediaan:</td>
                    <td class="p-4 text-center text-base text-gray-900">{{ number_format($totalStockUnits) }} pcs</td>
                    <td colspan="3" class="p-4 text-right text-gray-800 uppercase">Total Nilai Aset Fisik:</td>
                    <td class="p-4 text-right text-base text-amber-950 font-mono">Rp {{ number_format($totalAssetValue, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
