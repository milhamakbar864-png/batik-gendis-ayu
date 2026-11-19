@extends('layouts.admin')

@section('page_title', 'Monitoring Persediaan & Stok Produk')

@section('content')
<div class="space-y-6">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6">
        {{-- Total Unit Stok --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-boxes-stacked text-2xl text-blue-600"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Unit Stok</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalUnits, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Unit di semua varian</p>
            </div>
        </div>

        {{-- Nilai Aset Persediaan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-coins text-2xl text-emerald-600"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nilai Aset Persediaan</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalAssetValue, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Total stok × harga beli</p>
            </div>
        </div>

        {{-- Produk Stok Kritis --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-14 h-14 rounded-xl bg-rose-50 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-triangle-exclamation text-2xl text-rose-600"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Produk Stok Kritis</p>
                <p class="text-2xl font-bold {{ $criticalCount > 0 ? 'text-rose-600' : 'text-gray-800' }}">{{ $criticalCount }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Stok ≤ safety stock</p>
            </div>
        </div>
    </div>

    {{-- Filters & Search --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <form action="{{ route('admin.inventory.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3">
            {{-- Search --}}
            <div class="flex-1">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="q" value="{{ request('q') }}"
                           class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition"
                           placeholder="Cari nama produk, SKU, motif...">
                </div>
            </div>

            {{-- Category Filter --}}
            <div class="w-full lg:w-52">
                <select name="category_id"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Status Filter --}}
            <div class="w-full lg:w-48">
                <select name="status"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-batik-gold/40 focus:border-batik-gold outline-none transition bg-white">
                    <option value="">Semua Status Stok</option>
                    <option value="safe" {{ request('status') == 'safe' ? 'selected' : '' }}>Stok Aman</option>
                    <option value="low" {{ request('status') == 'low' ? 'selected' : '' }}>Stok Rendah</option>
                    <option value="out" {{ request('status') == 'out' ? 'selected' : '' }}>Habis / Kosong</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 text-sm font-semibold bg-batik-gold text-white px-5 py-2.5 rounded-xl hover:bg-batik-goldHover transition shadow-sm">
                    <i class="fa-solid fa-filter"></i>
                    Filter
                </button>
                <a href="{{ route('admin.inventory.index') }}"
                   class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 px-4 py-2.5 rounded-xl transition">
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Quick Action Links --}}
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.inventory.stockIn') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold bg-emerald-600 text-white px-5 py-2.5 rounded-xl hover:bg-emerald-700 transition shadow-sm">
            <i class="fa-solid fa-arrow-down"></i>
            Barang Masuk (Restock)
        </a>
        <a href="{{ route('admin.inventory.stockOut') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold bg-rose-600 text-white px-5 py-2.5 rounded-xl hover:bg-rose-700 transition shadow-sm">
            <i class="fa-solid fa-arrow-up"></i>
            Barang Keluar
        </a>
        <a href="{{ route('admin.inventory.movements') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 transition shadow-sm">
            <i class="fa-solid fa-clipboard-list"></i>
            Kartu Stok & Mutasi
        </a>
        <a href="{{ route('admin.inventory.alerts') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold bg-amber-500 text-white px-5 py-2.5 rounded-xl hover:bg-amber-600 transition shadow-sm">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Peringatan Stok
        </a>
    </div>

    {{-- Inventory Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-left px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Produk</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">SKU</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Kategori</th>
                        <th class="text-center px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Total Stok</th>
                        <th class="text-center px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Safety Stock</th>
                        <th class="text-right px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Harga Beli</th>
                        <th class="text-right px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Nilai Stok</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Varian</th>
                        <th class="text-center px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        @php
                            $stockStatus = $product->stock_status;
                            $stockValue = $product->total_stock * $product->buy_price;
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition">
                            {{-- Produk --}}
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                             class="w-10 h-10 rounded-lg object-cover border border-gray-200 flex-shrink-0">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-image text-gray-300"></i>
                                        </div>
                                    @endif
                                    <span class="font-semibold text-gray-800 line-clamp-1">{{ $product->name }}</span>
                                </div>
                            </td>

                            {{-- SKU --}}
                            <td class="px-4 py-3">
                                <span class="font-mono text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-md">{{ $product->sku }}</span>
                            </td>

                            {{-- Kategori --}}
                            <td class="px-4 py-3 text-gray-600">{{ $product->category->name ?? '-' }}</td>

                            {{-- Total Stok --}}
                            <td class="px-4 py-3 text-center">
                                @if($stockStatus === 'in_stock')
                                    <span class="inline-flex items-center gap-1 text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-circle text-[6px]"></i>
                                        {{ $product->total_stock }}
                                    </span>
                                @elseif($stockStatus === 'low_stock')
                                    <span class="inline-flex items-center gap-1 text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-circle text-[6px]"></i>
                                        {{ $product->total_stock }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-bold bg-rose-100 text-rose-800 border border-rose-300 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-circle text-[6px]"></i>
                                        {{ $product->total_stock }}
                                    </span>
                                @endif
                            </td>

                            {{-- Safety Stock --}}
                            <td class="px-4 py-3 text-center text-gray-600 font-medium">{{ $product->min_stock }}</td>

                            {{-- Harga Beli --}}
                            <td class="px-4 py-3 text-right text-gray-700 font-medium">{{ $product->formatted_buy_price }}</td>

                            {{-- Nilai Stok --}}
                            <td class="px-4 py-3 text-right font-semibold text-gray-800">Rp {{ number_format($stockValue, 0, ',', '.') }}</td>

                            {{-- Varian --}}
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($product->variants as $variant)
                                        <span class="inline-block text-xs bg-gray-100 text-gray-600 border border-gray-200 px-2 py-0.5 rounded-md">
                                            {{ $variant->size }}: <strong>{{ $variant->stock }}</strong>
                                        </span>
                                    @endforeach
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.inventory.stockIn') }}?product_id={{ $product->id }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition" title="Stok Masuk">
                                        <i class="fa-solid fa-arrow-down text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.inventory.stockOut') }}?product_id={{ $product->id }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition" title="Stok Keluar">
                                        <i class="fa-solid fa-arrow-up text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center text-gray-400">
                                <i class="fa-solid fa-box-open text-4xl mb-3"></i>
                                <p class="text-sm">Tidak ada produk ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $products->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
