@extends('layouts.admin')
@section('page_title', 'Dashboard Utama')
@section('content')
<!-- Top Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div><span class="text-xs text-gray-500 block">Total Pendapatan</span><span class="text-xl font-bold text-gray-900 mt-1 block">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span></div>
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-xl"><i class="fa-solid fa-sack-dollar"></i></div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div><span class="text-xs text-gray-500 block">Pendapatan Bulan Ini</span><span class="text-xl font-bold text-gray-900 mt-1 block">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</span></div>
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-xl"><i class="fa-solid fa-chart-line"></i></div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div><span class="text-xs text-gray-500 block">Total Pesanan</span><span class="text-xl font-bold text-gray-900 mt-1 block">{{ $totalOrdersCount }}</span>
                @if($pendingOrdersCount > 0)<span class="text-[10px] bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full font-bold">{{ $pendingOrdersCount }} perlu verifikasi</span>@endif
            </div>
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center text-xl"><i class="fa-solid fa-cart-shopping"></i></div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div><span class="text-xs text-gray-500 block">Stok Persediaan</span><span class="text-xl font-bold text-gray-900 mt-1 block">{{ number_format($totalStockUnits) }} unit</span>
                <span class="text-[10px] text-gray-500">Nilai: Rp {{ number_format($inventoryAssetValue, 0, ',', '.') }}</span>
            </div>
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center text-xl"><i class="fa-solid fa-boxes-stacked"></i></div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Sales Chart -->
    <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <h3 class="font-bold text-gray-900 text-sm mb-5 flex items-center gap-2"><i class="fa-solid fa-chart-bar text-batik-gold"></i> Grafik Penjualan 7 Hari Terakhir</h3>
        @php $maxSale = max(array_column($dailySales, 'total')) ?: 1; @endphp
        <div class="flex items-end justify-between gap-2 h-40">
            @foreach($dailySales as $day)
                <div class="flex-1 flex flex-col items-center gap-1">
                    <span class="text-[9px] text-gray-500 font-semibold">Rp {{ number_format($day['total']/1000, 0) }}k</span>
                    <div class="w-full bg-amber-400 rounded-t-lg transition-all duration-500 hover:bg-amber-500" style="height: {{ $maxSale > 0 ? max(4, ($day['total']/$maxSale)*100) : 4 }}%"></div>
                    <span class="text-[10px] text-gray-500">{{ $day['date'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Peringatan Stok Kritis</h3>
        @if($lowStockProducts->isEmpty())
            <div class="text-center py-6"><div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-2"><i class="fa-solid fa-check"></i></div><p class="text-xs text-gray-500">Semua stok aman</p></div>
        @else
            <div class="space-y-3 max-h-56 overflow-y-auto">
                @foreach($lowStockProducts as $p)
                    <div class="flex items-center justify-between p-2 rounded-xl {{ $p->total_stock <= 0 ? 'bg-rose-50 border border-rose-200' : 'bg-amber-50 border border-amber-200' }}">
                        <div class="text-xs"><p class="font-semibold text-gray-800 truncate max-w-[180px]">{{ $p->name }}</p><p class="text-gray-500">{{ $p->category->name }}</p></div>
                        <div class="text-right"><span class="text-xs font-bold {{ $p->total_stock <= 0 ? 'text-rose-600' : 'text-amber-600' }}">{{ $p->total_stock }}/{{ $p->min_stock }}</span></div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('admin.inventory.alerts') }}" class="block text-center text-xs font-semibold text-batik-gold hover:underline mt-3">Lihat Semua →</a>
        @endif
    </div>
</div>

<!-- Recent Orders & Movements -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2"><i class="fa-solid fa-clock-rotate-left text-batik-gold"></i> Pesanan Terbaru</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-batik-gold font-semibold hover:underline">Semua →</a>
        </div>
        <div class="space-y-2">
            @foreach($recentOrders as $o)
                <a href="{{ route('admin.orders.show', $o) }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition border border-gray-50">
                    <div class="text-xs"><p class="font-mono font-bold text-gray-800">{{ $o->order_number }}</p><p class="text-gray-500">{{ $o->customer_name }} &bull; {{ $o->created_at->diffForHumans() }}</p></div>
                    <div class="text-right"><span class="text-xs font-bold text-amber-900 block">{{ $o->formatted_total }}</span><span class="text-[10px] px-2 py-0.5 rounded-full border {{ $o->status_badge_color }}">{{ $o->status_label }}</span></div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2"><i class="fa-solid fa-clipboard-list text-batik-gold"></i> Mutasi Persediaan Terbaru</h3>
            <a href="{{ route('admin.inventory.movements') }}" class="text-xs text-batik-gold font-semibold hover:underline">Semua →</a>
        </div>
        <div class="space-y-2">
            @foreach($recentMovements as $m)
                <div class="flex items-center justify-between p-3 rounded-xl border border-gray-50">
                    <div class="text-xs"><p class="font-semibold text-gray-800 truncate max-w-[200px]">{{ $m->product->name }}</p><p class="text-gray-500">{{ $m->variant?->size ?? '-' }} &bull; {{ $m->created_at->diffForHumans() }}</p></div>
                    <div class="text-right"><span class="text-[10px] px-2 py-0.5 rounded-full border {{ $m->type_badge_color }}">{{ $m->type_label }}</span><p class="text-xs font-bold mt-0.5 {{ $m->quantity > 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $m->quantity > 0 ? '+' : '' }}{{ $m->quantity }}</p></div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
