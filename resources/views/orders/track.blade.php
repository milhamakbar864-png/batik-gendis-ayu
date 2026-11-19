@extends('layouts.app')

@section('title', 'Lacak Status Pesanan - Batik Gendis Ayu')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="text-center max-w-2xl mx-auto mb-10 space-y-3">
        <span class="text-xs uppercase tracking-widest text-batik-gold font-bold">Pelacakan Transaksi Real-Time</span>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-gray-900">Lacak Status Pesanan Anda</h1>
        <p class="text-xs text-gray-500 leading-relaxed font-light">
            Masukkan Nomor Pesanan (misal: <code>ORD-BGA-202611-0001</code>) atau nomor WhatsApp yang Anda gunakan saat checkout untuk memantau proses pengemasan dan resi kurir.
        </p>

        <!-- Search Input -->
        <form method="GET" action="{{ route('order.track') }}" class="pt-4 max-w-lg mx-auto">
            <div class="flex items-center gap-2 bg-white p-2 rounded-full border border-amber-200 shadow-sm focus-within:ring-2 focus-within:ring-amber-500/20">
                <i class="fa-solid fa-magnifying-glass text-gray-400 pl-4 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" required
                       placeholder="Nomor Pesanan atau No. WhatsApp..."
                       class="w-full text-xs sm:text-sm p-2 outline-none bg-transparent text-gray-800">
                <button type="submit"
                        class="bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold px-6 py-2.5 rounded-full text-xs transition shadow-sm flex-shrink-0">
                    Lacak
                </button>
            </div>
        </form>
    </div>

    <!-- Search Result -->
    @if(isset($order))
        <div class="bg-white rounded-3xl border border-amber-100 shadow-md overflow-hidden space-y-6 p-6 sm:p-8 animate-fade-in">
            <!-- Order Header Info -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-gray-100">
                <div>
                    <span class="text-xs text-gray-400">Nomor Pesanan</span>
                    <h2 class="font-mono text-xl font-bold text-amber-950">{{ $order->order_number }}</h2>
                    <span class="text-xs text-gray-500">Waktu Pemesanan: {{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $order->payment_badge_color }}">
                        {{ $order->payment_status_label }}
                    </span>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $order->status_badge_color }}">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>

            <!-- Order Timeline -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-700 mb-6">Status Progres Pesanan</h3>
                <div class="relative flex flex-col sm:flex-row justify-between gap-6 sm:gap-2">
                    <!-- Step 1: Dibuat -->
                    <div class="flex-1 flex sm:flex-col items-center sm:text-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center text-sm shadow-sm">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">Pesanan Dibuat</p>
                            <p class="text-[11px] text-gray-500">Menunggu Pembayaran</p>
                        </div>
                    </div>

                    <!-- Step 2: Pembayaran Terverifikasi -->
                    <div class="flex-1 flex sm:flex-col items-center sm:text-center gap-3">
                        <div class="w-10 h-10 rounded-full {{ in_array($order->payment_status, ['paid']) ? 'bg-emerald-600 text-white' : ($order->payment_status === 'pending_verification' ? 'bg-amber-500 text-gray-900 animate-pulse' : 'bg-gray-200 text-gray-400') }} flex items-center justify-center text-sm shadow-sm">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">Verifikasi Pembayaran</p>
                            <p class="text-[11px] text-gray-500">
                                {{ $order->payment_status === 'paid' ? 'Lunas Terverifikasi' : ($order->payment_status === 'pending_verification' ? 'Menunggu Konfirmasi' : 'Belum Bayar') }}
                            </p>
                        </div>
                    </div>

                    <!-- Step 3: Pengemasan & Quality Control -->
                    <div class="flex-1 flex sm:flex-col items-center sm:text-center gap-3">
                        <div class="w-10 h-10 rounded-full {{ in_array($order->order_status, ['processing', 'shipped', 'completed']) ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center text-sm shadow-sm">
                            <i class="fa-solid fa-box"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">Pengemasan (QC)</p>
                            <p class="text-[11px] text-gray-500">Pengecekan Kualitas Batik</p>
                        </div>
                    </div>

                    <!-- Step 4: Dalam Pengiriman -->
                    <div class="flex-1 flex sm:flex-col items-center sm:text-center gap-3">
                        <div class="w-10 h-10 rounded-full {{ in_array($order->order_status, ['shipped', 'completed']) ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center text-sm shadow-sm">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">Dalam Pengiriman</p>
                            <p class="text-[11px] text-gray-500">Kurir: {{ $order->courier }}</p>
                        </div>
                    </div>

                    <!-- Step 5: Selesai -->
                    <div class="flex-1 flex sm:flex-col items-center sm:text-center gap-3">
                        <div class="w-10 h-10 rounded-full {{ $order->order_status === 'completed' ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center text-sm shadow-sm">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">Pesanan Selesai</p>
                            <p class="text-[11px] text-gray-500">Paket Diterima</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tracking Number (Resi) Box if shipped -->
            @if($order->tracking_number)
                <div class="p-4 bg-indigo-50 border border-indigo-200 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center text-base">
                            <i class="fa-solid fa-barcode"></i>
                        </div>
                        <div>
                            <span class="text-xs text-indigo-700 block font-medium">Nomor Resi Kurir ({{ $order->courier }}):</span>
                            <span class="font-mono text-base font-bold text-indigo-950 tracking-wider">{{ $order->tracking_number }}</span>
                        </div>
                    </div>
                    <span class="text-xs bg-white text-indigo-800 px-3 py-1.5 rounded-lg border border-indigo-200 font-semibold shadow-sm">
                        Sedang Dalam Perjalanan Kurir
                    </span>
                </div>
            @endif

            <!-- Order Items Table -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-700 mb-3">Item Yang Dipesan</h3>
                <div class="border border-gray-100 rounded-2xl overflow-hidden divide-y divide-gray-100">
                    @foreach($order->items as $item)
                        <div class="p-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-14 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0 border border-gray-200">
                                    <img src="{{ $item->product?->image ?: 'https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?q=80&w=300&auto=format&fit=crop' }}"
                                         alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="text-xs">
                                    <p class="font-semibold text-gray-800">{{ $item->product_name }}</p>
                                    <p class="text-gray-400">Ukuran: {{ $item->variant_size }} &bull; {{ $item->quantity }} pcs</p>
                                </div>
                            </div>
                            <span class="font-bold text-xs text-amber-900">{{ $item->formatted_subtotal }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Footer Action Links -->
            <div class="pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4 text-xs">
                <div class="flex items-center gap-3">
                    <a href="{{ route('order.payment', $order->order_number) }}"
                       class="inline-flex items-center gap-2 bg-batik-brown text-batik-gold hover:bg-batik-dark font-semibold px-4 py-2 rounded-xl transition">
                        <i class="fa-solid fa-credit-card"></i>
                        <span>Instruksi Bayar & Bukti</span>
                    </a>
                    <a href="{{ route('order.invoice', $order->order_number) }}" target="_blank"
                       class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-xl transition">
                        <i class="fa-solid fa-print"></i>
                        <span>Cetak Nota / Invoice</span>
                    </a>
                </div>

                <div class="text-right">
                    <span class="text-gray-400 block">Total Transaksi:</span>
                    <span class="font-bold text-base text-amber-900">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
