@extends('layouts.app')

@section('title', 'Keranjang Belanja - Batik Gendis Ayu')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-bold text-gray-900">Keranjang Belanja</h1>
        <p class="text-xs text-gray-500 mt-1">Periksa kembali pesanan busana dan kain batik pilihan Anda sebelum melanjutkan ke pembayaran.</p>
    </div>

    @if(empty($cart))
        <div class="bg-white rounded-3xl p-12 text-center border border-amber-100 shadow-sm max-w-lg mx-auto">
            <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto text-batik-gold text-3xl mb-4">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <h3 class="font-serif text-xl font-bold text-gray-800">Keranjang Belanja Anda Kosong</h3>
            <p class="text-xs text-gray-500 mt-2 mb-6 leading-relaxed">
                Anda belum menambahkan busana atau kain batik ke dalam keranjang. Silakan jelajahi koleksi mahakarya kami.
            </p>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold px-7 py-3 rounded-full text-xs shadow-md transition">
                <span>Mulai Belanja Batik</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Cart Items List -->
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden">
                    <div class="p-4 bg-amber-50/60 border-b border-amber-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Daftar Produk ({{ count($cart) }} Item)
                        </span>
                        <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('Kosongkan semua item di keranjang?')">
                            @csrf
                            <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 flex items-center gap-1 font-semibold">
                                <i class="fa-regular fa-trash-can"></i> Kosongkan
                            </button>
                        </form>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @foreach($cart as $key => $item)
                            <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <!-- Thumb -->
                                <div class="w-20 h-24 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0 border border-gray-200">
                                    <img src="{{ $item['image'] ?: 'https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?q=80&w=400&auto=format&fit=crop' }}"
                                         alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                </div>

                                <!-- Item Details -->
                                <div class="flex-1 min-w-0">
                                    <span class="text-[10px] text-gray-400 font-mono">SKU: {{ $item['sku'] }}</span>
                                    <h3 class="font-medium text-gray-900 text-sm hover:text-batik-gold truncate">
                                        <a href="{{ route('shop.show', $item['slug']) }}">{{ $item['name'] }}</a>
                                    </h3>
                                    <div class="text-xs text-gray-500 mt-1 flex items-center gap-3">
                                        <span>Ukuran: <strong class="text-gray-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">{{ $item['size'] }}</strong></span>
                                        <span>•</span>
                                        <span class="text-amber-900 font-semibold">Rp {{ number_format($item['price'], 0, ',', '.') }} / pcs</span>
                                    </div>
                                </div>

                                <!-- Quantity Form -->
                                <div class="flex items-center gap-4">
                                    <form method="POST" action="{{ route('cart.update') }}" class="flex items-center border border-gray-200 rounded-lg overflow-hidden bg-white">
                                        @csrf
                                        <input type="hidden" name="cart_key" value="{{ $key }}">
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}"
                                                class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100"
                                                {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                            <i class="fa-solid fa-minus text-[10px]"></i>
                                        </button>
                                        <span class="w-10 text-center text-xs font-bold text-gray-800">{{ $item['quantity'] }}</span>
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                                                class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100"
                                                {{ $item['quantity'] >= $item['max_stock'] ? 'disabled' : '' }}>
                                            <i class="fa-solid fa-plus text-[10px]"></i>
                                        </button>
                                    </form>

                                    <!-- Subtotal -->
                                    <div class="text-right min-w-[100px]">
                                        <span class="text-sm font-bold text-gray-900 block">
                                            Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <!-- Delete Button -->
                                    <form method="POST" action="{{ route('cart.remove') }}">
                                        @csrf
                                        <input type="hidden" name="cart_key" value="{{ $key }}">
                                        <button type="submit" class="text-gray-400 hover:text-rose-600 p-1 transition" title="Hapus Item">
                                            <i class="fa-solid fa-xmark text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-between items-center text-xs text-gray-500 pt-2">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 text-batik-gold hover:underline font-semibold">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Lanjutkan Memilih Batik Lain</span>
                    </a>
                    <span>Total Estimasi Berat Paket: <strong>{{ number_format($totalWeight) }} gram</strong></span>
                </div>
            </div>

            <!-- Order Summary Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl p-6 border border-amber-100 shadow-sm space-y-5 sticky top-28">
                    <h3 class="font-serif text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">
                        Ringkasan Pesanan
                    </h3>

                    <div class="space-y-3 text-xs text-gray-600">
                        <div class="flex justify-between">
                            <span>Total Item</span>
                            <span class="font-semibold text-gray-800">{{ array_sum(array_column($cart, 'quantity')) }} pcs</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Subtotal Belanja</span>
                            <span class="font-semibold text-gray-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>Ongkos Kirim</span>
                            <span>Dihitung saat checkout</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4 flex justify-between items-baseline">
                        <span class="text-sm font-bold text-gray-900">Total Estimasi</span>
                        <span class="font-serif text-2xl font-bold text-amber-900">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <a href="{{ route('checkout.index') }}"
                       class="w-full inline-flex items-center justify-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold py-3.5 px-6 rounded-full shadow-md hover:shadow-lg transition text-xs uppercase tracking-wider">
                        <span>Lanjut ke Checkout</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                    <!-- Guarantee notes -->
                    <div class="text-[11px] text-gray-400 text-center space-y-1 pt-2 border-t border-gray-50">
                        <p><i class="fa-solid fa-lock text-emerald-500 mr-1"></i> Transaksi Aman & Terenkripsi</p>
                        <p><i class="fa-solid fa-check text-batik-gold mr-1"></i> Stok Persediaan Direservasi Otomatis</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
