@extends('layouts.admin')

@section('page_title', 'Detail Pesanan: ' . $order->order_number)

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.orders.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 hover:text-batik-dark transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold font-serif text-batik-dark">Detail Pesanan</h1>
                <p class="text-sm text-gray-500 mt-0.5">{{ $order->order_number }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-batik-dark text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition">
                <i class="fas fa-file-invoice"></i>
                <span>Lihat Invoice</span>
            </a>
        </div>
    </div>

    {{-- Order Header --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-batik-gold/10 flex items-center justify-center">
                    <i class="fas fa-receipt text-xl text-batik-gold"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold font-mono text-batik-dark">{{ $order->order_number }}</h2>
                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $order->status_badge_color }}">
                    {{ $order->status_label }}
                </span>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $order->payment_badge_color }}">
                    {{ $order->payment_status_label }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Customer Info Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-base font-bold text-batik-dark mb-4 flex items-center gap-2">
                <i class="fas fa-user text-batik-gold"></i>
                Informasi Pelanggan
            </h3>
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <span class="text-gray-400 w-5 text-center"><i class="fas fa-user-circle"></i></span>
                    <div>
                        <p class="text-xs text-gray-400">Nama Lengkap</p>
                        <p class="text-sm font-medium text-batik-dark">{{ $order->customer_name }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-gray-400 w-5 text-center"><i class="fas fa-envelope"></i></span>
                    <div>
                        <p class="text-xs text-gray-400">Email</p>
                        <p class="text-sm font-medium text-batik-dark">{{ $order->customer_email ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-gray-400 w-5 text-center"><i class="fas fa-phone"></i></span>
                    <div>
                        <p class="text-xs text-gray-400">No. Telepon</p>
                        <p class="text-sm font-medium text-batik-dark">{{ $order->customer_phone }}</p>
                    </div>
                </div>
                @if($order->customer_notes)
                    <div class="flex items-start gap-3">
                        <span class="text-gray-400 w-5 text-center"><i class="fas fa-sticky-note"></i></span>
                        <div>
                            <p class="text-xs text-gray-400">Catatan Pelanggan</p>
                            <p class="text-sm text-batik-dark">{{ $order->customer_notes }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Shipping Info Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-base font-bold text-batik-dark mb-4 flex items-center gap-2">
                <i class="fas fa-truck text-batik-gold"></i>
                Informasi Pengiriman
            </h3>
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <span class="text-gray-400 w-5 text-center"><i class="fas fa-map-marker-alt"></i></span>
                    <div>
                        <p class="text-xs text-gray-400">Alamat Lengkap</p>
                        <p class="text-sm font-medium text-batik-dark">{{ $order->shipping_address }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-gray-400 w-5 text-center"><i class="fas fa-city"></i></span>
                    <div>
                        <p class="text-xs text-gray-400">Kota / Kabupaten</p>
                        <p class="text-sm font-medium text-batik-dark">{{ $order->city }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-gray-400 w-5 text-center"><i class="fas fa-map"></i></span>
                    <div>
                        <p class="text-xs text-gray-400">Provinsi</p>
                        <p class="text-sm font-medium text-batik-dark">{{ $order->province }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-gray-400 w-5 text-center"><i class="fas fa-mail-bulk"></i></span>
                    <div>
                        <p class="text-xs text-gray-400">Kode Pos</p>
                        <p class="text-sm font-medium text-batik-dark">{{ $order->postal_code }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-gray-400 w-5 text-center"><i class="fas fa-shipping-fast"></i></span>
                    <div>
                        <p class="text-xs text-gray-400">Kurir</p>
                        <p class="text-sm font-medium text-batik-dark">{{ $order->courier ?? '-' }}</p>
                    </div>
                </div>
                @if($order->tracking_number)
                    <div class="flex items-start gap-3">
                        <span class="text-gray-400 w-5 text-center"><i class="fas fa-barcode"></i></span>
                        <div>
                            <p class="text-xs text-gray-400">No. Resi</p>
                            <p class="text-sm font-bold font-mono text-batik-gold">{{ $order->tracking_number }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Items Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-base font-bold text-batik-dark flex items-center gap-2">
                <i class="fas fa-box-open text-batik-gold"></i>
                Item Pesanan
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-batik-cream/50 border-b border-gray-100">
                        <th class="text-left px-5 py-3 font-semibold text-batik-dark">Produk</th>
                        <th class="text-center px-5 py-3 font-semibold text-batik-dark">Ukuran</th>
                        <th class="text-center px-5 py-3 font-semibold text-batik-dark">Jumlah</th>
                        <th class="text-right px-5 py-3 font-semibold text-batik-dark">Harga</th>
                        <th class="text-right px-5 py-3 font-semibold text-batik-dark">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($order->items as $item)
                        <tr class="hover:bg-batik-warmGray/30 transition-colors">
                            <td class="px-5 py-4">
                                <span class="font-medium text-batik-dark">{{ $item->product_name }}</span>
                            </td>
                            <td class="px-5 py-4 text-center text-gray-600">
                                {{ $item->variant_size ?? '-' }}
                            </td>
                            <td class="px-5 py-4 text-center font-medium text-batik-dark">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-5 py-4 text-right text-gray-600 whitespace-nowrap">
                                {{ $item->formatted_price }}
                            </td>
                            <td class="px-5 py-4 text-right font-semibold text-batik-dark whitespace-nowrap">
                                {{ $item->formatted_subtotal }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-batik-cream/30">
                    <tr class="border-t border-gray-200">
                        <td colspan="4" class="px-5 py-3 text-right text-sm text-gray-500">Subtotal Produk</td>
                        <td class="px-5 py-3 text-right font-semibold text-batik-dark whitespace-nowrap">{{ $order->formatted_subtotal }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="px-5 py-3 text-right text-sm text-gray-500">Ongkos Kirim</td>
                        <td class="px-5 py-3 text-right font-semibold text-batik-dark whitespace-nowrap">{{ $order->formatted_shipping_cost }}</td>
                    </tr>
                    <tr class="border-t-2 border-batik-gold/30">
                        <td colspan="4" class="px-5 py-4 text-right text-base font-bold text-batik-dark">Total Pembayaran</td>
                        <td class="px-5 py-4 text-right text-lg font-bold text-batik-gold whitespace-nowrap">{{ $order->formatted_total }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Payment Proof Section --}}
    @if($order->payment_proof)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-base font-bold text-batik-dark mb-4 flex items-center gap-2">
                <i class="fas fa-image text-batik-gold"></i>
                Bukti Pembayaran
            </h3>
            <div x-data="{ showModal: false }">
                <div class="relative inline-block cursor-pointer group" @click="showModal = true">
                    <img src="{{ asset('storage/' . $order->payment_proof) }}"
                         alt="Bukti Pembayaran {{ $order->order_number }}"
                         class="max-w-sm w-full rounded-lg border border-gray-200 shadow-sm group-hover:opacity-90 transition">
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black/20 rounded-lg">
                        <span class="bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-lg text-xs font-semibold text-batik-dark">
                            <i class="fas fa-search-plus mr-1"></i> Perbesar
                        </span>
                    </div>
                </div>

                {{-- Full Screen Modal --}}
                <div x-show="showModal" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4"
                     @click.self="showModal = false"
                     @keydown.escape.window="showModal = false">
                    <div class="relative max-w-4xl w-full max-h-[90vh]">
                        <button @click="showModal = false"
                                class="absolute -top-3 -right-3 w-8 h-8 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 hover:text-red-500 transition z-10">
                            <i class="fas fa-times"></i>
                        </button>
                        <img src="{{ asset('storage/' . $order->payment_proof) }}"
                             alt="Bukti Pembayaran"
                             class="w-full h-auto max-h-[85vh] object-contain rounded-lg">
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Payment Verification Form --}}
        @if($order->payment_status === 'pending_verification')
            <div class="bg-white rounded-xl shadow-sm border-2 border-yellow-300 p-5">
                <h3 class="text-base font-bold text-batik-dark mb-4 flex items-center gap-2">
                    <i class="fas fa-check-double text-yellow-500"></i>
                    Verifikasi Pembayaran
                </h3>
                <form action="{{ route('admin.orders.verifyPayment', $order) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-batik-dark mb-2">Tindakan <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-6">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="action" value="approve" required
                                       class="w-4 h-4 text-green-500 border-gray-300 focus:ring-green-400">
                                <span class="text-sm font-medium text-green-700">
                                    <i class="fas fa-check-circle mr-1"></i> Setujui (Approve)
                                </span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="action" value="reject" required
                                       class="w-4 h-4 text-red-500 border-gray-300 focus:ring-red-400">
                                <span class="text-sm font-medium text-red-700">
                                    <i class="fas fa-times-circle mr-1"></i> Tolak (Reject)
                                </span>
                            </label>
                        </div>
                        @error('action')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="verify_admin_notes" class="block text-sm font-semibold text-batik-dark mb-2">Catatan Admin</label>
                        <textarea name="admin_notes" id="verify_admin_notes" rows="3"
                                  placeholder="Tambahkan catatan verifikasi (opsional)..."
                                  class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-batik-gold focus:border-batik-gold transition resize-none">{{ old('admin_notes') }}</textarea>
                        @error('admin_notes')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-yellow-500 text-white text-sm font-bold rounded-lg hover:bg-yellow-600 transition shadow-sm">
                        <i class="fas fa-gavel"></i>
                        <span>Verifikasi Pembayaran</span>
                    </button>
                </form>
            </div>
        @endif

        {{-- Order Status Update Form --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-base font-bold text-batik-dark mb-4 flex items-center gap-2">
                <i class="fas fa-sync-alt text-batik-gold"></i>
                Update Status Pesanan
            </h3>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="space-y-4" x-data="{ status: '{{ $order->order_status }}' }">
                @csrf
                <div>
                    <label for="order_status" class="block text-sm font-semibold text-batik-dark mb-2">Status Pesanan <span class="text-red-500">*</span></label>
                    <select name="order_status" id="order_status" required x-model="status"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-batik-gold focus:border-batik-gold bg-white transition">
                        <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                        <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Diproses (Processing)</option>
                        <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Dikirim (Shipped)</option>
                        <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                    </select>
                    @error('order_status')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div x-show="status === 'shipped'" x-cloak x-transition>
                    <label for="tracking_number" class="block text-sm font-semibold text-batik-dark mb-2">Nomor Resi Pengiriman</label>
                    <input type="text" name="tracking_number" id="tracking_number"
                           value="{{ old('tracking_number', $order->tracking_number) }}"
                           placeholder="Masukkan nomor resi..."
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-batik-gold focus:border-batik-gold transition font-mono">
                    @error('tracking_number')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status_admin_notes" class="block text-sm font-semibold text-batik-dark mb-2">Catatan Admin</label>
                    <textarea name="admin_notes" id="status_admin_notes" rows="3"
                              placeholder="Tambahkan catatan update status (opsional)..."
                              class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-batik-gold focus:border-batik-gold transition resize-none">{{ old('admin_notes') }}</textarea>
                    @error('admin_notes')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-batik-gold text-white text-sm font-bold rounded-lg hover:bg-batik-goldHover transition shadow-sm">
                    <i class="fas fa-save"></i>
                    <span>Update Status Pesanan</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Admin Notes --}}
    @if($order->admin_notes)
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
            <h3 class="text-base font-bold text-amber-800 mb-2 flex items-center gap-2">
                <i class="fas fa-clipboard text-amber-500"></i>
                Catatan Admin
            </h3>
            <p class="text-sm text-amber-900 whitespace-pre-line">{{ $order->admin_notes }}</p>
        </div>
    @endif
</div>
@endsection
