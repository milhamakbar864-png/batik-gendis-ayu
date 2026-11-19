@extends('layouts.app')
@section('title', 'Kontak & Galeri - Batik Gendis Ayu')
@section('content')
<div class="bg-[#1b1d22] text-white py-12 border-b-2 border-batik-gold">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs uppercase tracking-widest text-batik-gold font-bold">Hubungi Kami</span>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold mt-1">Kontak & Lokasi Galeri Batik Gendis Ayu</h1>
        <p class="text-gray-300 text-sm mt-2 font-light">Kami siap melayani pertanyaan, konsultasi motif, maupun pemesanan khusus seragam & hampers.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contact Info Cards -->
        <div class="lg:col-span-1 space-y-5">
            @foreach([
                ['icon'=>'fa-location-dot','color'=>'text-rose-500','title'=>'Alamat Galeri','text'=>'Jl. Malioboro No. 45, Sosromenduran, Gedongtengen, Kota Yogyakarta, D.I. Yogyakarta 55271'],
                ['icon'=>'fa-phone','color'=>'text-emerald-500','title'=>'Telepon','text'=>'0812-3456-7890'],
                ['icon'=>'fa-brands fa-whatsapp','color'=>'text-emerald-500','title'=>'WhatsApp CS','text'=>'0812-3456-7890 (Chat/Call)'],
                ['icon'=>'fa-envelope','color'=>'text-blue-500','title'=>'Email Resmi','text'=>'info@batikgendisayu.com'],
                ['icon'=>'fa-brands fa-instagram','color'=>'text-pink-500','title'=>'Instagram','text'=>'@batikgendisayu'],
                ['icon'=>'fa-clock','color'=>'text-amber-500','title'=>'Jam Operasional','text'=>'Senin – Minggu: 09.00 – 21.00 WIB'],
            ] as $c)
                <div class="bg-white p-5 rounded-2xl border border-amber-100 shadow-sm flex items-start gap-4 hover:shadow-md transition">
                    <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0"><i class="fa-solid {{ $c['icon'] }} {{ $c['color'] }} text-lg"></i></div>
                    <div><h4 class="font-bold text-gray-900 text-sm">{{ $c['title'] }}</h4><p class="text-xs text-gray-600 mt-0.5 leading-relaxed">{{ $c['text'] }}</p></div>
                </div>
            @endforeach

            <a href="https://wa.me/6281234567890?text=Halo%20Batik%20Gendis%20Ayu" target="_blank" class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 rounded-full shadow-md transition text-xs">
                <i class="fa-brands fa-whatsapp text-lg"></i> Chat WhatsApp Sekarang
            </a>
        </div>

        <!-- Map & FAQ -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-gray-200 rounded-2xl overflow-hidden border border-gray-300 aspect-[16/9] flex items-center justify-center">
                <div class="text-center text-gray-500 p-8">
                    <i class="fa-solid fa-map-location-dot text-4xl text-gray-400 mb-3 block"></i>
                    <p class="text-sm font-semibold text-gray-700">Peta Lokasi Galeri Batik Gendis Ayu</p>
                    <p class="text-xs mt-1">Jl. Malioboro No. 45, Yogyakarta — Google Maps</p>
                </div>
            </div>

            <!-- FAQ Accordion -->
            <div class="bg-white p-6 rounded-2xl border border-amber-100 shadow-sm">
                <h3 class="font-serif text-lg font-bold text-gray-900 mb-5 flex items-center gap-2"><i class="fa-solid fa-circle-question text-batik-gold"></i> Pertanyaan Umum (FAQ)</h3>
                <div class="space-y-3" x-data="{ open: null }">
                    @foreach([
                        ['q'=>'Apakah semua produk batik asli tulis/cap?', 'a'=>'Ya, semua produk kami 100% batik asli tradisional, baik tulis maupun cap. Kami tidak menjual batik printing/sablon.'],
                        ['q'=>'Bagaimana cara memesan dan membayar?', 'a'=>'Pilih produk, masukkan ke keranjang, checkout, lalu transfer ke rekening resmi kami (BCA/Mandiri/BRI). Upload bukti transfer dan admin akan memverifikasi.'],
                        ['q'=>'Berapa lama pengiriman sampai?', 'a'=>'Estimasi 2-4 hari kerja untuk Pulau Jawa, 4-7 hari kerja untuk luar Jawa via JNE/J&T/SiCepat.'],
                        ['q'=>'Apakah bisa retur atau tukar ukuran?', 'a'=>'Bisa! Kami memberikan garansi tukar ukuran dalam 7 hari sejak paket diterima, dengan syarat kondisi produk masih baru dan berlabel.'],
                        ['q'=>'Apakah menerima pesanan seragam custom?', 'a'=>'Tentu! Kami melayani pesanan seragam batik instansi, komunitas, pernikahan, dan hampers. Hubungi CS via WhatsApp.'],
                    ] as $i => $faq)
                        <div class="border border-gray-100 rounded-xl overflow-hidden">
                            <button @click="open = open === {{ $i }} ? null : {{ $i }}" class="w-full text-left p-4 flex items-center justify-between text-sm font-semibold text-gray-800 hover:bg-amber-50/50 transition">
                                <span>{{ $faq['q'] }}</span>
                                <i :class="open === {{ $i }} ? 'fa-chevron-up' : 'fa-chevron-down'" class="fa-solid text-batik-gold text-xs"></i>
                            </button>
                            <div x-show="open === {{ $i }}" x-cloak class="px-4 pb-4 text-xs text-gray-600 leading-relaxed border-t border-gray-50">{{ $faq['a'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
