@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_number . ' - Batik Gendis Ayu')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb & Back -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('order.track', ['search' => $order->order_number]) }}" class="inline-flex items-center gap-2 text-xs font-semibold text-batik-gold hover:underline">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Lacak Pesanan</span>
        </a>
        <a href="{{ route('order.invoice', $order->order_number) }}" target="_blank"
           class="inline-flex items-center gap-2 bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-200 px-4 py-2 rounded-xl text-xs font-semibold shadow-sm transition">
            <i class="fa-solid fa-print text-batik-gold"></i>
            <span>Cetak Invoice Resmi</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-amber-100 shadow-sm p-6 sm:p-8 space-y-8">
        <!-- Order Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-gray-100">
            <div>
                <span class="text-xs text-gray-400">Nomor Pesanan</span>
                <h1 class="font-mono text-2xl font-bold text-amber-950">{{ $order->order_number }}</h1>
                <p class="text-xs text-gray-500 mt-0.5">Dipesan pada: {{ $order->created_at->format('d F Y, H:i') }} WIB</p>
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

        <!-- Tracking Number Alert -->
        @if($order->tracking_number)
            <div class="p-4 bg-indigo-50 border border-indigo-200 rounded-2xl flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-truck-fast text-indigo-600 text-xl"></i>
                    <div>
                        <span class="text-xs text-indigo-700 block font-medium">Nomor Resi Pengiriman ({{ $order->courier }})</span>
                        <span class="font-mono text-base font-bold text-indigo-950 tracking-wider">{{ $order->tracking_number }}</span>
                    </div>
                </div>
                <span class="text-xs text-indigo-800 bg-white px-3 py-1.5 rounded-lg border border-indigo-200 font-semibold">
                    Dalam Pengiriman
                </span>
            </div>
        @endif

        <!-- Customer & Shipping Information Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs text-gray-600">
            <div class="bg-[#fdfbf7] p-5 rounded-2xl border border-amber-100 space-y-2">
                <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-user text-batik-gold"></i>
                    <span>Informasi Pembeli</span>
                </h3>
                <p><span class="text-gray-400">Nama Penerima:</span> <strong class="text-gray-800">{{ $order->customer_name }}</strong></p>
                <p><span class="text-gray-400">Email:</span> {{ $order->customer_email }}</p>
                <p><span class="text-gray-400">No. WhatsApp / HP:</span> {{ $order->customer_phone }}</p>
                @if($order->customer_notes)
                    <p class="pt-2 border-t border-amber-200/50 text-[11px] italic text-amber-900">
                        Catatan: "{{ $order->customer_notes }}"
                    </p>
                @endif
            </div>

            <div class="bg-[#fdfbf7] p-5 rounded-2xl border border-amber-100 space-y-2">
                <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-batik-gold"></i>
                    <span>Alamat & Ekspedisi Pengiriman</span>
                </h3>
                <p><span class="text-gray-400">Alamat Lengkap:</span> {{ $order->shipping_address }}</p>
                <p><span class="text-gray-400">Kota / Provinsi:</span> {{ $order->city }}, {{ $order->province }} ({{ $order->postal_code ?? '-' }})</p>
                <p><span class="text-gray-400">Jasa Kurir:</span> <strong class="text-gray-800">{{ $order->courier }}</strong></p>
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="space-y-3">
            <h3 class="font-serif text-base font-bold text-gray-900">Rincian Item Produk</h3>
            <div class="border border-gray-100 rounded-2xl overflow-hidden divide-y divide-gray-100">
                @foreach($order->items as $item)
                    <div class="p-4 sm:p-5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-16 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0 border border-gray-200">
                                <img src="{{ $item->product?->image ?: 'https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?q=80&w=300&auto=format&fit=crop' }}"
                                     alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm">{{ $item->product_name }}</h4>
                                <div class="text-xs text-gray-400 mt-0.5 space-x-2">
                                    <span>Ukuran: <strong class="text-gray-700">{{ $item->variant_size }}</strong></span>
                                    <span>&bull;</span>
                                    <span>{{ $item->quantity }} pcs x {{ $item->formatted_price }}</span>
                                </div>
                            </div>
                        </div>
                        <span class="font-bold text-sm text-amber-900">{{ $item->formatted_subtotal }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Calculation Totals -->
        <div class="border-t border-gray-100 pt-6 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6">
            <div class="space-y-1 text-xs text-gray-500">
                <p>Metode Pembayaran: <strong class="text-gray-800">{{ $order->payment_method }}</strong></p>
                @if($order->payment_date)
                    <p>Waktu Transfer: {{ $order->payment_date->format('d M Y, H:i') }} WIB</p>
                @endif
                @if($order->payment_status === 'unpaid')
                    <div class="pt-2">
                        <a href="{{ route('order.payment', $order->order_number) }}"
                           class="inline-flex items-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold px-4 py-2 rounded-xl shadow-sm text-xs transition">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span>Unggah Bukti Transfer Sekarang</span>
                        </a>
                    </div>
                @endif
            </div>

            <div class="w-full sm:w-64 space-y-2 text-xs text-gray-600">
                <div class="flex justify-between">
                    <span>Subtotal Produk</span>
                    <span class="font-semibold text-gray-800">{{ $order->formatted_subtotal }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Biaya Ongkos Kirim</span>
                    <span class="font-semibold text-gray-800">{{ $order->formatted_shipping_cost }}</span>
                </div>
                <div class="border-t border-gray-200 pt-2 flex justify-between items-baseline text-sm">
                    <span class="font-bold text-gray-900">Total Transaksi</span>
                    <span class="font-serif text-xl font-bold text-amber-900">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
