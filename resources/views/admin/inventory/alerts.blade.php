@extends('layouts.admin')

@section('page_title', 'Peringatan Stok Kritis (Safety Stock & Reorder Point)')

@section('content')
<div class="space-y-6">
    <!-- Informative Banner on Safety Stock -->
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 text-xs text-amber-900 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="space-y-1">
            <h3 class="font-bold text-sm flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-amber-600 text-base"></i>
                <span>Metode Manajemen Persediaan: Safety Stock & Reorder Point (ROP)</span>
            </h3>
            <p class="text-amber-800 leading-relaxed max-w-2xl">
                Sistem secara otomatis mendeteksi produk batik yang persediaannya telah mencapai atau berada di bawah ambang batas stok minimum (Safety Stock). Segera lakukan pengadaan ulang (restock) ke pengrajin rekanan guna menghindari kehabisan stok (stockout).
            </p>
        </div>
        <a href="{{ route('admin.inventory.stockIn') }}"
           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-2.5 rounded-xl shadow-sm transition whitespace-nowrap">
            <i class="fa-solid fa-plus"></i>
            <span>Restock Barang Sekarang</span>
        </a>
    </div>

    @if($criticalProducts->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-lg mx-auto">
            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto text-3xl mb-4">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h3 class="font-serif text-lg font-bold text-gray-800">Semua Persediaan Dalam Kondisi Aman!</h3>
            <p class="text-xs text-gray-500 mt-1 mb-6">
                Tidak ada produk yang berada di bawah ambang batas safety stock saat ini.
            </p>
            <a href="{{ route('admin.inventory.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-batik-gold hover:underline">
                <span>Kembali ke Monitoring Persediaan</span> &rarr;
            </a>
        </div>
    @else
        <!-- Grid of Critical Products -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($criticalProducts as $p)
                @php
                    $isOutOfStock = $p->total_stock <= 0;
                    $deficit = max(0, $p->min_stock - $p->total_stock);
                @endphp
                <div class="bg-white rounded-2xl border {{ $isOutOfStock ? 'border-rose-300 ring-1 ring-rose-300' : 'border-amber-200' }} shadow-sm overflow-hidden flex flex-col justify-between">
                    <div>
                        <!-- Header Bar -->
                        <div class="p-4 {{ $isOutOfStock ? 'bg-rose-50' : 'bg-amber-50' }} border-b {{ $isOutOfStock ? 'border-rose-100' : 'border-amber-100' }} flex items-center justify-between">
                            <span class="text-[11px] font-mono font-bold text-gray-700">{{ $p->sku }}</span>
                            @if($isOutOfStock)
                                <span class="bg-rose-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">
                                    Stok Habis (0 Pcs)
                                </span>
                            @else
                                <span class="bg-amber-500 text-gray-900 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">
                                    Menipis (Defisit: {{ $deficit }} pcs)
                                </span>
                            @endif
                        </div>

                        <!-- Product Summary -->
                        <div class="p-5 space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-20 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0 border border-gray-200">
                                    <img src="{{ $p->image ?: 'https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?q=80&w=300&auto=format&fit=crop' }}"
                                         alt="{{ $p->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0 text-xs">
                                    <span class="text-[10px] text-batik-gold uppercase font-bold block">{{ $p->category->name }}</span>
                                    <h4 class="font-bold text-gray-900 text-sm line-clamp-2">{{ $p->name }}</h4>
                                    <p class="text-gray-500 mt-1">Motif: {{ $p->motif ?? '-' }}</p>
                                </div>
                            </div>

                            <!-- Stock vs Minimum -->
                            <div class="grid grid-cols-2 gap-3 p-3 bg-gray-50 rounded-xl text-center text-xs">
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase">Stok Tersedia</span>
                                    <span class="font-bold text-base {{ $isOutOfStock ? 'text-rose-600' : 'text-amber-600' }}">
                                        {{ $p->total_stock }} pcs
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase">Safety Stock (Min)</span>
                                    <span class="font-bold text-base text-gray-800">
                                        {{ $p->min_stock }} pcs
                                    </span>
                                </div>
                            </div>

                            <!-- Variants Breakdown -->
                            <div class="space-y-1.5">
                                <span class="text-[11px] font-bold text-gray-700 block">Rincian Stok per Varian:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($p->variants as $v)
                                        <span class="text-[10px] px-2 py-1 rounded-lg border {{ $v->stock <= 0 ? 'bg-rose-50 text-rose-700 border-rose-200 font-bold' : ($v->stock <= 2 ? 'bg-amber-50 text-amber-800 border-amber-200 font-semibold' : 'bg-gray-100 text-gray-700 border-gray-200') }}">
                                            {{ $v->size }}: {{ $v->stock }} pcs
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-xs">
                        <a href="{{ route('admin.products.edit', $p) }}" class="text-gray-600 hover:text-batik-gold font-semibold">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                        </a>
                        <a href="{{ route('admin.inventory.stockIn') }}"
                           class="inline-flex items-center gap-1.5 bg-batik-brown text-batik-gold hover:bg-batik-dark font-bold px-3 py-1.5 rounded-lg transition shadow-xs">
                            <i class="fa-solid fa-arrow-down text-[10px]"></i>
                            <span>Restock</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
