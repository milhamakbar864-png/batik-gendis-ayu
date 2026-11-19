@extends('layouts.admin')

@section('page_title', 'Kartu Stok & Jurnal Mutasi Persediaan')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Shortcuts -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <p class="text-xs text-gray-500">
                Pencatatan mutasi riil setiap perubahan stok batik (penerimaan, penjualan checkout, retur, opname).
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.inventory.stockIn') }}"
               class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-sm transition">
                <i class="fa-solid fa-arrow-down"></i>
                <span>Barang Masuk</span>
            </a>
            <a href="{{ route('admin.inventory.stockOut') }}"
               class="inline-flex items-center gap-1.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-sm transition">
                <i class="fa-solid fa-arrow-up"></i>
                <span>Barang Keluar</span>
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
        <form method="GET" action="{{ route('admin.inventory.movements') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 text-xs">
            <!-- Product Filter -->
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Produk Batik</label>
                <select name="product_id" class="w-full p-2.5 border border-gray-200 rounded-xl focus:border-batik-gold outline-none bg-white">
                    <option value="">Semua Produk</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->sku }} - {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Type Filter -->
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Jenis Mutasi</label>
                <select name="type" class="w-full p-2.5 border border-gray-200 rounded-xl focus:border-batik-gold outline-none bg-white">
                    <option value="">Semua Jenis</option>
                    <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Masuk (Restock / Pembelian)</option>
                    <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>Penjualan (Checkout)</option>
                    <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Keluar (Retur / Rusak)</option>
                    <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>Penyesuaian (Opname)</option>
                </select>
            </div>

            <!-- Start Date -->
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                       class="w-full p-2.5 border border-gray-200 rounded-xl focus:border-batik-gold outline-none">
            </div>

            <!-- End Date -->
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                       class="w-full p-2.5 border border-gray-200 rounded-xl focus:border-batik-gold outline-none">
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit"
                        class="flex-1 bg-batik-brown text-batik-gold hover:bg-batik-dark font-bold py-2.5 px-4 rounded-xl shadow-sm transition text-center">
                    Filter Mutasi
                </button>
                @if(request()->hasAny(['product_id', 'type', 'start_date', 'end_date']))
                    <a href="{{ route('admin.inventory.movements') }}" class="p-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-center" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table of Movements -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
        <table class="w-full text-xs text-left min-w-[950px]">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase tracking-wider">
                    <th class="p-4">Waktu</th>
                    <th class="p-4">Produk Batik</th>
                    <th class="p-4 text-center">Ukuran</th>
                    <th class="p-4">Jenis & No. Referensi</th>
                    <th class="p-4 text-center">Qty Mutasi</th>
                    <th class="p-4 text-center">Saldo Stok</th>
                    <th class="p-4 text-right">Biaya/Unit (HPP)</th>
                    <th class="p-4">Keterangan</th>
                    <th class="p-4">Petugas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($movements as $m)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-gray-500 whitespace-nowrap">
                            <span class="block font-medium text-gray-800">{{ $m->created_at->format('d/m/Y') }}</span>
                            <span class="text-[10px] text-gray-400">{{ $m->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td class="p-4">
                            <span class="font-semibold text-gray-800 block truncate max-w-[200px]">{{ $m->product?->name }}</span>
                            <span class="font-mono text-[10px] text-gray-400">{{ $m->product?->sku }}</span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="bg-amber-50 text-amber-900 border border-amber-200 px-2 py-0.5 rounded font-bold">
                                {{ $m->variant?->size ?? '-' }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="inline-block text-[10px] font-semibold px-2 py-0.5 rounded-full border mb-1 {{ $m->type_badge_color }}">
                                {{ $m->type_label }}
                            </span>
                            <span class="block font-mono text-[11px] text-gray-600 truncate max-w-[150px]">
                                {{ $m->reference_number ?: '-' }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="font-mono text-sm font-bold {{ $m->quantity > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $m->quantity > 0 ? '+' : '' }}{{ $m->quantity }}
                            </span>
                        </td>
                        <td class="p-4 text-center font-mono">
                            <span class="text-gray-400">{{ $m->stock_before }}</span>
                            <span class="text-gray-400 mx-1">&rarr;</span>
                            <strong class="text-gray-900">{{ $m->stock_after }}</strong>
                        </td>
                        <td class="p-4 text-right font-mono text-gray-700">
                            {{ $m->unit_cost ? 'Rp ' . number_format($m->unit_cost, 0, ',', '.') : '-' }}
                        </td>
                        <td class="p-4 text-gray-600 max-w-[220px]">
                            <p class="truncate" title="{{ $m->notes }}">{{ $m->notes ?: '-' }}</p>
                        </td>
                        <td class="p-4 text-gray-500 whitespace-nowrap">
                            {{ $m->creator?->name ?? 'Sistem' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-8 text-center text-gray-400">
                            Belum ada riwayat mutasi persediaan yang sesuai filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $movements->links() }}
    </div>
</div>
@endsection
