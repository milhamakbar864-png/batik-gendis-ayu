@extends('layouts.admin')

@section('page_title', 'Manajemen Pesanan & Transaksi')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold font-serif text-batik-dark">Manajemen Pesanan & Transaksi</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola semua pesanan dan transaksi pelanggan</p>
        </div>
    </div>

    {{-- Stats Bar --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
        <a href="{{ route('admin.orders.index') }}"
           class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow text-center {{ !request('order_status') ? 'ring-2 ring-batik-gold' : '' }}">
            <div class="text-2xl font-bold text-batik-dark">{{ number_format($counts['all'] ?? 0) }}</div>
            <div class="text-xs text-gray-500 mt-1">Semua Pesanan</div>
        </a>
        <a href="{{ route('admin.orders.index', ['payment_status' => 'pending_verification']) }}"
           class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow text-center {{ request('payment_status') === 'pending_verification' ? 'ring-2 ring-yellow-400' : '' }}">
            <div class="text-2xl font-bold text-yellow-600">{{ number_format($counts['pending_verification'] ?? 0) }}</div>
            <div class="text-xs text-gray-500 mt-1">Menunggu Verifikasi</div>
        </a>
        <a href="{{ route('admin.orders.index', ['order_status' => 'processing']) }}"
           class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow text-center {{ request('order_status') === 'processing' ? 'ring-2 ring-blue-400' : '' }}">
            <div class="text-2xl font-bold text-blue-600">{{ number_format($counts['processing'] ?? 0) }}</div>
            <div class="text-xs text-gray-500 mt-1">Diproses</div>
        </a>
        <a href="{{ route('admin.orders.index', ['order_status' => 'shipped']) }}"
           class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow text-center {{ request('order_status') === 'shipped' ? 'ring-2 ring-indigo-400' : '' }}">
            <div class="text-2xl font-bold text-indigo-600">{{ number_format($counts['shipped'] ?? 0) }}</div>
            <div class="text-xs text-gray-500 mt-1">Dikirim</div>
        </a>
        <a href="{{ route('admin.orders.index', ['order_status' => 'completed']) }}"
           class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow text-center {{ request('order_status') === 'completed' ? 'ring-2 ring-green-400' : '' }}">
            <div class="text-2xl font-bold text-green-600">{{ number_format($counts['completed'] ?? 0) }}</div>
            <div class="text-xs text-gray-500 mt-1">Selesai</div>
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Cari nomor pesanan, nama, atau telepon..."
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-batik-gold focus:border-batik-gold transition">
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <select name="order_status"
                        class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-batik-gold focus:border-batik-gold bg-white transition">
                    <option value="">Semua Status Pesanan</option>
                    <option value="pending" {{ request('order_status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="processing" {{ request('order_status') === 'processing' ? 'selected' : '' }}>Diproses</option>
                    <option value="shipped" {{ request('order_status') === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                    <option value="completed" {{ request('order_status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('order_status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <select name="payment_status"
                        class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-batik-gold focus:border-batik-gold bg-white transition">
                    <option value="">Semua Status Pembayaran</option>
                    <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                    <option value="pending_verification" {{ request('payment_status') === 'pending_verification' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Lunas</option>
                    <option value="rejected" {{ request('payment_status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-batik-gold text-white text-sm font-semibold rounded-lg hover:bg-batik-goldHover transition">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                </button>
                @if(request()->hasAny(['q', 'order_status', 'payment_status']))
                    <a href="{{ route('admin.orders.index') }}"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200 transition">
                        <i class="fas fa-times"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Orders Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-batik-cream/50 border-b border-gray-100">
                        <th class="text-left px-5 py-3.5 font-semibold text-batik-dark">No. Pesanan</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-batik-dark">Pelanggan</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-batik-dark hidden md:table-cell">Telepon</th>
                        <th class="text-right px-5 py-3.5 font-semibold text-batik-dark">Total</th>
                        <th class="text-center px-5 py-3.5 font-semibold text-batik-dark">Status Pesanan</th>
                        <th class="text-center px-5 py-3.5 font-semibold text-batik-dark">Pembayaran</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-batik-dark hidden lg:table-cell">Tanggal</th>
                        <th class="text-center px-5 py-3.5 font-semibold text-batik-dark">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                        <tr class="hover:bg-batik-warmGray/30 transition-colors">
                            <td class="px-5 py-4">
                                <span class="font-mono font-semibold text-batik-dark">{{ $order->order_number }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-medium text-batik-dark">{{ $order->customer_name }}</div>
                            </td>
                            <td class="px-5 py-4 hidden md:table-cell text-gray-500">
                                {{ $order->customer_phone }}
                            </td>
                            <td class="px-5 py-4 text-right font-semibold text-batik-dark whitespace-nowrap">
                                {{ $order->formatted_total }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->status_badge_color }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->payment_badge_color }}">
                                    {{ $order->payment_status_label }}
                                </span>
                            </td>
                            <td class="px-5 py-4 hidden lg:table-cell text-gray-500 whitespace-nowrap">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-batik-gold bg-batik-gold/10 rounded-lg hover:bg-batik-gold/20 transition">
                                    <i class="fas fa-eye"></i>
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-inbox text-2xl text-gray-300"></i>
                                    </div>
                                    <p class="text-gray-400 font-medium">Belum ada pesanan ditemukan</p>
                                    @if(request()->hasAny(['q', 'order_status', 'payment_status']))
                                        <a href="{{ route('admin.orders.index') }}" class="text-sm text-batik-gold hover:underline">
                                            Hapus semua filter
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 bg-batik-cream/30">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
