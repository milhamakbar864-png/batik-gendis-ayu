@extends('layouts.app')

@section('title', 'Instruksi Pembayaran Pesanan ' . $order->order_number . ' - Batik Gendis Ayu')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Success Alert Header -->
    <div class="bg-amber-50 border border-amber-200 rounded-3xl p-6 sm:p-8 text-center space-y-3 mb-8 shadow-sm">
        <div class="w-16 h-16 bg-batik-gold/20 text-batik-brown rounded-full flex items-center justify-center mx-auto text-2xl">
            <i class="fa-solid fa-receipt text-batik-gold"></i>
        </div>
        <span class="text-xs font-bold uppercase tracking-widest text-batik-gold">Pesanan Berhasil Dicatat</span>
        <h1 class="font-serif text-2xl sm:text-3xl font-bold text-gray-900">
            Selesaikan Pembayaran Pesanan Anda
        </h1>
        <p class="text-xs sm:text-sm text-gray-600 max-w-xl mx-auto leading-relaxed">
            Terima kasih telah berbelanja di Batik Gendis Ayu. Silakan transfer nominal yang tepat ke salah satu rekening resmi kami di bawah ini.
        </p>

        <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-full border border-amber-200 text-xs font-mono text-gray-800">
            <span>Nomor Pesanan:</span>
            <strong class="text-amber-900 font-bold">{{ $order->order_number }}</strong>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
        
        <!-- Left Column: Bank Accounts & Amount -->
        <div class="space-y-6">
            <!-- Total to Pay Card -->
            <div class="bg-white p-6 rounded-2xl border border-amber-100 shadow-sm space-y-2">
                <span class="text-xs uppercase font-bold text-gray-500 tracking-wider">Total Yang Harus Ditransfer:</span>
                <div class="flex items-baseline justify-between">
                    <span class="font-serif text-3xl font-bold text-amber-900">{{ $order->formatted_total }}</span>
                    <span class="text-[11px] bg-amber-50 text-amber-800 px-2 py-0.5 rounded font-semibold border border-amber-200">
                        {{ $order->payment_status_label }}
                    </span>
                </div>
                <p class="text-[11px] text-gray-400">Pastikan mentransfer sesuai nominal persis hingga digit terakhir agar verifikasi otomatis lancar.</p>
            </div>

            <!-- Bank Accounts List -->
            <div class="bg-white p-6 rounded-2xl border border-amber-100 shadow-sm space-y-4">
                <h3 class="font-serif text-base font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-building-columns text-batik-gold"></i>
                    <span>Pilihan Rekening Bank Resmi</span>
                </h3>

                <div class="space-y-3">
                    @foreach($bankAccounts as $bank)
                        <div class="p-4 rounded-xl border {{ $order->payment_method == $bank->bank_name ? 'border-batik-gold bg-amber-50/50 ring-1 ring-amber-500/20' : 'border-gray-200 bg-gray-50' }} flex items-center justify-between">
                            <div>
                                <span class="font-bold text-sm text-gray-800 block">{{ $bank->bank_name }}</span>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="font-mono text-base font-bold text-amber-950 tracking-wider">{{ $bank->account_number }}</span>
                                </div>
                                <span class="text-xs text-gray-500 block mt-0.5">a.n. {{ $bank->account_holder }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column: Upload Proof of Payment -->
        <div class="bg-white p-6 rounded-2xl border border-amber-100 shadow-sm space-y-6">
            <div>
                <h3 class="font-serif text-base font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-up text-batik-gold"></i>
                    <span>Unggah Bukti Transfer</span>
                </h3>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                    Setelah melakukan transfer melalui ATM, m-Banking, atau internet banking, silakan upload bukti screenshot / foto struk transfer Anda di bawah ini:
                </p>
            </div>

            @if($order->payment_proof)
                <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-200 space-y-3">
                    <div class="flex items-center gap-2 text-emerald-800 text-xs font-bold">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                        <span>Bukti transfer telah berhasil diunggah!</span>
                    </div>
                    <div class="aspect-[4/3] rounded-lg overflow-hidden border border-emerald-200 bg-white">
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Transfer" class="w-full h-full object-contain">
                    </div>
                    <p class="text-[11px] text-emerald-700">
                        Status saat ini: <strong>{{ $order->payment_status_label }}</strong>. Admin akan segera memverifikasi pesanan Anda.
                    </p>
                </div>
            @endif

            <form method="POST" action="{{ route('order.uploadProof', $order->order_number) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Pilih File Foto Bukti Transfer <span class="text-rose-500">*</span>
                    </label>
                    <input type="file" name="payment_proof" accept="image/*" required
                           class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-batik-brown file:text-batik-gold hover:file:bg-batik-dark cursor-pointer border border-gray-200 rounded-xl p-2 bg-gray-50">
                    <span class="text-[10px] text-gray-400 block mt-1">Format gambar: JPG, PNG, WEBP (Maksimal 3 MB).</span>
                </div>

                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold py-3.5 px-6 rounded-full shadow-md hover:shadow-lg transition text-xs uppercase tracking-wider">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>Kirim Bukti Pembayaran</span>
                </button>
            </form>

            <div class="border-t border-gray-100 pt-4 flex items-center justify-between text-xs">
                <a href="{{ route('order.detail', $order->order_number) }}" class="text-batik-gold hover:underline font-semibold">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Rincian Pesanan
                </a>
                <a href="{{ route('order.invoice', $order->order_number) }}" target="_blank" class="text-gray-600 hover:text-batik-gold">
                    <i class="fa-solid fa-print mr-1"></i> Cetak Invoice
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
