@extends('layouts.app')

@section('title', 'Checkout Pengiriman & Pembayaran - Batik Gendis Ayu')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
     x-data="{
        subtotal: {{ $subtotal }},
        totalWeight: {{ $totalWeight }},
        courier: 'JNE Regular',
        courierRates: {
            'JNE Regular': 18000,
            'J&T Express EZ': 20000,
            'SiCepat REG': 19000,
            'POS Kilat Khusus': 17000
        },
        get weightKg() {
            return Math.max(1, Math.ceil(this.totalWeight / 1000));
        },
        get shippingCost() {
            return (this.courierRates[this.courier] || 18000) * this.weightKg;
        },
        get grandTotal() {
            return this.subtotal + this.shippingCost;
        },
        formatRupiah(val) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
        }
     }">

    <div class="mb-8">
        <h1 class="font-serif text-3xl font-bold text-gray-900">Checkout Pengiriman</h1>
        <p class="text-xs text-gray-500 mt-1">Lengkapi data penerima dan pilih metode pembayaran transfer untuk memproses pesanan Anda.</p>
    </div>

    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Left 2 Cols: Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Section 1: Customer Info -->
                <div class="bg-white p-6 rounded-2xl border border-amber-100 shadow-sm space-y-4">
                    <h3 class="font-serif text-base font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-user-check text-batik-gold"></i>
                        <span>1. Data Penerima Paket</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Lengkap Penerima <span class="text-rose-500">*</span></label>
                            <input type="text" name="customer_name" value="{{ old('customer_name', $user?->name) }}" required
                                   class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none"
                                   placeholder="Contoh: Raden Ayu Sekar Arum">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nomor WhatsApp / HP Aktif <span class="text-rose-500">*</span></label>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone', $user?->phone) }}" required
                                   class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none"
                                   placeholder="Contoh: 081234567890">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Alamat Email (Untuk Notifikasi Pesanan) <span class="text-rose-500">*</span></label>
                            <input type="email" name="customer_email" value="{{ old('customer_email', $user?->email) }}" required
                                   class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none"
                                   placeholder="emailanda@gmail.com">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Shipping Destination -->
                <div class="bg-white p-6 rounded-2xl border border-amber-100 shadow-sm space-y-4">
                    <h3 class="font-serif text-base font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-truck-ramp-box text-batik-gold"></i>
                        <span>2. Alamat Lengkap Pengiriman</span>
                    </h3>

                    <div class="space-y-4 text-xs">
                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Alamat Jalan, RT/RW, No. Rumah, Patokan <span class="text-rose-500">*</span></label>
                            <textarea name="shipping_address" rows="3" required
                                      class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none"
                                      placeholder="Nama jalan lengkap, nomor rumah, RT/RW, kelurahan/desa, kecamatan">{{ old('shipping_address', $user?->address) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kota / Kabupaten <span class="text-rose-500">*</span></label>
                                <input type="text" name="city" value="{{ old('city', $user?->city ?? 'Yogyakarta') }}" required
                                       class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none">
                            </div>

                            <div>
                                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Provinsi <span class="text-rose-500">*</span></label>
                                <input type="text" name="province" value="{{ old('province', 'D.I. Yogyakarta') }}" required
                                       class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none">
                            </div>

                            <div>
                                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kode Pos</label>
                                <input type="text" name="postal_code" value="{{ old('postal_code', $user?->postal_code) }}"
                                       class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none"
                                       placeholder="55271">
                            </div>
                        </div>

                        <!-- Courier Selection -->
                        <div class="pt-2">
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih Ekspedisi Pengiriman <span class="text-rose-500">*</span></label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($couriers as $name => $rate)
                                    <label class="flex items-center justify-between p-3.5 border rounded-xl cursor-pointer transition"
                                           :class="courier === '{{ $name }}' ? 'border-batik-gold bg-amber-50/70 ring-2 ring-amber-500/20' : 'border-gray-200 bg-white hover:border-amber-300'">
                                        <div class="flex items-center gap-3">
                                            <input type="radio" name="courier" value="{{ $name }}" x-model="courier"
                                                   class="text-amber-600 focus:ring-amber-500">
                                            <div>
                                                <span class="font-bold text-sm text-gray-800">{{ $name }}</span>
                                                <span class="block text-[11px] text-gray-400">Estimasi 2-3 hari kerja</span>
                                            </div>
                                        </div>
                                        <span class="font-semibold text-xs text-amber-900" x-text="formatRupiah(courierRates['{{ $name }}'] * weightKg)"></span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Catatan Khusus untuk Penjual / Kurir (Opsional)</label>
                            <input type="text" name="customer_notes" value="{{ old('customer_notes') }}"
                                   class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none"
                                   placeholder="Misal: Titipkan ke satpam jika tidak ada orang di rumah">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Payment Method -->
                <div class="bg-white p-6 rounded-2xl border border-amber-100 shadow-sm space-y-4">
                    <h3 class="font-serif text-base font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-credit-card text-batik-gold"></i>
                        <span>3. Metode Pembayaran Transfer Bank Resmi</span>
                    </h3>

                    <div class="space-y-3 text-xs">
                        <p class="text-gray-500">Pilih rekening tujuan transfer. Anda akan diberikan instruksi nomor rekening dan unggah bukti transfer setelah checkout.</p>
                        
                        <div class="space-y-2.5">
                            @foreach($bankAccounts as $bank)
                                <label class="flex items-center justify-between p-3.5 border border-gray-200 rounded-xl cursor-pointer hover:border-batik-gold transition bg-white">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="{{ $bank->bank_name }}" {{ $loop->first ? 'checked' : '' }}
                                               class="text-amber-600 focus:ring-amber-500">
                                        <div>
                                            <span class="font-bold text-sm text-gray-800">{{ $bank->bank_name }}</span>
                                            <span class="block text-[11px] text-gray-500">No. Rek: <strong class="font-mono text-gray-700">{{ $bank->account_number }}</strong> a/n {{ $bank->account_holder }}</span>
                                        </div>
                                    </div>
                                    <span class="text-xs bg-amber-50 text-amber-800 px-2 py-1 rounded font-semibold border border-amber-200">Verifikasi Otomatis</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right 1 Col: Summary & Submit -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl p-6 border border-amber-100 shadow-sm space-y-5 sticky top-28">
                    <h3 class="font-serif text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">
                        Rincian Pesanan
                    </h3>

                    <!-- Mini Cart Items List -->
                    <div class="space-y-3 max-h-60 overflow-y-auto divide-y divide-gray-50 pr-1">
                        @foreach($cart as $item)
                            <div class="pt-2 first:pt-0 flex items-center gap-3">
                                <div class="w-12 h-14 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0 border border-gray-200">
                                    <img src="{{ $item['image'] ?: 'https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?q=80&w=400&auto=format&fit=crop' }}"
                                         alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0 text-xs">
                                    <p class="font-semibold text-gray-800 truncate">{{ $item['name'] }}</p>
                                    <p class="text-gray-400">Ukuran: {{ $item['size'] }} &bull; {{ $item['quantity'] }} pcs</p>
                                    <p class="font-bold text-amber-900 mt-0.5">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 pt-4 space-y-2.5 text-xs text-gray-600">
                        <div class="flex justify-between">
                            <span>Subtotal Barang</span>
                            <span class="font-semibold text-gray-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Berat Total (<span x-text="totalWeight"></span> gr)</span>
                            <span class="font-semibold text-gray-800"><span x-text="weightKg"></span> Kg</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ongkos Kirim (<span x-text="courier"></span>)</span>
                            <span class="font-semibold text-gray-800" x-text="formatRupiah(shippingCost)"></span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4 flex justify-between items-baseline">
                        <span class="text-sm font-bold text-gray-900">Total Pembayaran</span>
                        <span class="font-serif text-2xl font-bold text-amber-900" x-text="formatRupiah(grandTotal)"></span>
                    </div>

                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold py-3.5 px-6 rounded-full shadow-md hover:shadow-lg transition text-xs uppercase tracking-wider">
                        <i class="fa-solid fa-lock text-sm"></i>
                        <span>Konfirmasi & Buat Pesanan</span>
                    </button>

                    <p class="text-[11px] text-gray-400 text-center leading-relaxed">
                        Dengan menekan tombol di atas, stok produk akan langsung dialokasikan untuk pesanan Anda di database persediaan.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
