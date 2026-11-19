@extends('layouts.app')
@section('title', 'Pesanan Saya - Batik Gendis Ayu')
@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="font-serif text-3xl font-bold text-gray-900">Pesanan Saya</h1>
            <p class="text-xs text-gray-500 mt-1">Riwayat seluruh transaksi belanja batik Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('customer.orders') }}" class="text-xs font-bold px-4 py-2 rounded-xl bg-batik-brown text-batik-gold border border-batik-gold/40">Pesanan Saya</a>
            <a href="{{ route('customer.profile') }}" class="text-xs font-semibold px-4 py-2 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition">Profil Akun</a>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center border border-amber-100 shadow-sm max-w-md mx-auto">
            <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mx-auto text-batik-gold text-2xl mb-4"><i class="fa-solid fa-box-open"></i></div>
            <h3 class="font-serif text-xl font-bold text-gray-800">Belum Ada Pesanan</h3>
            <p class="text-xs text-gray-500 mt-2 mb-6">Anda belum pernah melakukan pemesanan. Mulai jelajahi koleksi batik kami.</p>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold px-6 py-3 rounded-full text-xs shadow-md transition">Mulai Belanja <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-5 sm:p-6 hover:shadow-md transition">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="font-mono text-sm font-bold text-amber-950">{{ $order->order_number }}</span>
                                <span class="text-[10px] text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full border {{ $order->status_badge_color }}">{{ $order->status_label }}</span>
                                <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full border {{ $order->payment_badge_color }}">{{ $order->payment_status_label }}</span>
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $order->items->count() }} item &bull; Kurir: {{ $order->courier }}
                                @if($order->tracking_number) &bull; Resi: <span class="font-mono font-bold text-indigo-700">{{ $order->tracking_number }}</span>@endif
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="text-xs text-gray-400 block">Total</span>
                            <span class="font-serif text-lg font-bold text-amber-900 block">{{ $order->formatted_total }}</span>
                            <a href="{{ route('order.detail', $order->order_number) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-batik-gold hover:underline mt-2">Detail <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
