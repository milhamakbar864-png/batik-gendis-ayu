@extends('layouts.admin')

@section('page_title', 'Laporan Penjualan & Analisis Laba Rugi')

@section('content')
<div class="space-y-6">
    <!-- Filter Bar & Print Button -->
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.reports.sales') }}" class="flex flex-wrap items-center gap-3 text-xs">
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                       class="p-2.5 border border-gray-200 rounded-xl focus:border-batik-gold outline-none">
            </div>
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                       class="p-2.5 border border-gray-200 rounded-xl focus:border-batik-gold outline-none">
            </div>
            <div class="pt-5">
                <button type="submit"
                        class="bg-batik-brown text-batik-gold hover:bg-batik-dark font-bold py-2.5 px-4 rounded-xl shadow-sm transition">
                    <i class="fa-solid fa-filter mr-1"></i> Terapkan
                </button>
            </div>
        </form>

        <a href="{{ route('admin.reports.sales', ['start_date' => $startDate, 'end_date' => $endDate, 'print' => 1]) }}" target="_blank"
           class="inline-flex items-center gap-2 bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-200 font-bold text-xs px-4 py-2.5 rounded-xl shadow-sm transition whitespace-nowrap">
            <i class="fa-solid fa-print text-batik-gold"></i>
            <span>Cetak Laporan (PDF)</span>
        </a>
    </div>

    <!-- Summary Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-[11px] text-gray-500 block uppercase font-medium">Total Omzet Bruto</span>
            <span class="font-serif text-lg font-bold text-gray-900 block mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            <span class="text-[10px] text-gray-400">Termasuk ongkir</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-[11px] text-gray-500 block uppercase font-medium">Penjualan Produk</span>
            <span class="font-serif text-lg font-bold text-blue-900 block mt-1">Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</span>
            <span class="text-[10px] text-gray-400">Total nilai barang</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-[11px] text-gray-500 block uppercase font-medium">Total Ongkos Kirim</span>
            <span class="font-serif text-lg font-bold text-gray-700 block mt-1">Rp {{ number_format($totalShipping, 0, ',', '.') }}</span>
            <span class="text-[10px] text-gray-400">Diteruskan ke kurir</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-[11px] text-gray-500 block uppercase font-medium">Total HPP / Modal</span>
            <span class="font-serif text-lg font-bold text-rose-800 block mt-1">Rp {{ number_format($totalHpp, 0, ',', '.') }}</span>
            <span class="text-[10px] text-gray-400">Harga beli produk</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-emerald-200 bg-emerald-50/40 shadow-sm">
            <span class="text-[11px] text-emerald-800 block uppercase font-bold">Laba Bersih Penjualan</span>
            <span class="font-serif text-lg font-bold text-emerald-700 block mt-1">Rp {{ number_format($netProfit, 0, ',', '.') }}</span>
            <span class="text-[10px] text-emerald-600 font-semibold">Subtotal - HPP</span>
        </div>
    </div>

    <!-- Top Selling Products -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <h3 class="font-bold text-sm text-gray-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-trophy text-batik-gold"></i>
            <span>Top 5 Produk Batik Terlaris (Periode Terpilih)</span>
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            @forelse($topProducts as $idx => $tp)
                <div class="p-3.5 bg-gray-50 rounded-xl border border-gray-100 flex flex-col justify-between">
                    <div>
                        <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-900 font-bold text-xs flex items-center justify-center mb-2">
                            #{{ $idx + 1 }}
                        </span>
                        <h4 class="font-semibold text-xs text-gray-800 line-clamp-2">{{ $tp->product_name }}</h4>
                    </div>
                    <div class="mt-2 pt-2 border-t border-gray-200/60 text-xs">
                        <span class="text-gray-500 block text-[10px]">Terjual: <strong class="text-gray-900">{{ $tp->total_qty }} pcs</strong></span>
                        <span class="font-bold text-amber-900 text-[11px]">Rp {{ number_format($tp->total_sales, 0, ',', '.') }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-5 text-center py-4 text-xs text-gray-400">
                    Belum ada data penjualan pada rentang tanggal ini.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Orders Table in Period -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
        <div class="p-4 border-b border-gray-100">
            <h3 class="font-bold text-sm text-gray-800">Daftar Transaksi Terverifikasi ({{ $orders->count() }} Pesanan)</h3>
        </div>
        <table class="w-full text-xs text-left min-w-[850px]">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase tracking-wider">
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">No. Pesanan</th>
                    <th class="p-4">Nama Pelanggan</th>
                    <th class="p-4">Kota Tujuan</th>
                    <th class="p-4">Metode Bayar</th>
                    <th class="p-4 text-right">Subtotal</th>
                    <th class="p-4 text-right">Ongkir</th>
                    <th class="p-4 text-right">Total Transaksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $o)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-gray-600 whitespace-nowrap">{{ $o->created_at->format('d/m/Y H:i') }}</td>
                        <td class="p-4 font-mono font-bold text-amber-950">{{ $o->order_number }}</td>
                        <td class="p-4 font-semibold text-gray-800">{{ $o->customer_name }}</td>
                        <td class="p-4 text-gray-600">{{ $o->city }}</td>
                        <td class="p-4 text-gray-600">{{ $o->payment_method }}</td>
                        <td class="p-4 text-right font-mono">{{ $o->formatted_subtotal }}</td>
                        <td class="p-4 text-right font-mono text-gray-500">{{ $o->formatted_shipping_cost }}</td>
                        <td class="p-4 text-right font-bold text-amber-900 font-mono">{{ $o->formatted_total }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-gray-400">
                            Tidak ada data transaksi terverifikasi pada periode tanggal yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
