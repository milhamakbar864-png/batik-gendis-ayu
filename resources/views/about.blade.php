@extends('layouts.app')
@section('title', 'Tentang Kami - Batik Gendis Ayu')
@section('content')
<section class="bg-[#1b1d22] text-white py-20 border-b-4 border-batik-gold relative overflow-hidden">
    <div class="absolute inset-0 opacity-30 bg-cover bg-center" style="background-image:url('https://images.unsplash.com/photo-1590736969955-71cc94801759?q=80&w=1600&auto=format&fit=crop')"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/70 to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-2xl space-y-4">
            <span class="text-xs uppercase tracking-widest text-batik-gold font-bold">Tentang Galeri Batik Gendis Ayu</span>
            <h1 class="font-serif text-4xl sm:text-5xl font-bold leading-tight">Merawat Tradisi,<br><span class="text-batik-gold italic">Menginspirasi Generasi</span></h1>
            <p class="text-gray-300 text-sm leading-relaxed font-light">Didirikan di jantung kota budaya Yogyakarta, Batik Gendis Ayu hadir sebagai jembatan antara warisan leluhur dan gaya hidup masa kini.</p>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <span class="text-xs uppercase tracking-widest text-batik-gold font-bold">Sejarah & Kisah Kami</span>
                <h2 class="font-serif text-3xl font-bold text-gray-900">Bermula dari Cinta pada Seni Batik</h2>
                <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
                    <p>Sejak tahun 2018, <strong class="text-gray-800">Batik Gendis Ayu</strong> berdiri dengan tekad melestarikan keagungan batik nusantara. Bermula dari galeri kecil di kawasan Malioboro, Yogyakarta, kami menjalin kerjasama langsung dengan para maestro pembatik dari Solo, Pekalongan, Cirebon, dan Madura.</p>
                    <p>Nama "Gendis Ayu" berasal dari bahasa Jawa yang bermakna <em>"gadis cantik yang manis"</em>, merefleksikan keanggunan dan keindahan yang terpancar dari setiap motif batik yang kami hadirkan.</p>
                    <p>Kini, melalui platform penjualan online ini, kami membuka akses seluas-luasnya bagi pecinta batik di seluruh Indonesia untuk memiliki karya seni adibusana berkualitas tinggi langsung dari tangan perajin.</p>
                </div>
            </div>
            <div class="aspect-[4/3] rounded-3xl overflow-hidden shadow-xl border-2 border-amber-200">
                <img src="https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=800&auto=format&fit=crop" alt="Galeri Batik" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-[#f7f4ed]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs uppercase tracking-widest text-batik-gold font-bold">Filosofi & Teknik</span>
            <h2 class="font-serif text-3xl font-bold text-gray-900 mt-2">Mengenal Jenis Teknik Batik</h2>
            <div class="w-16 h-1 bg-batik-gold mx-auto mt-4 rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl border border-amber-100 shadow-sm text-center space-y-4 hover:shadow-lg transition">
                <div class="w-16 h-16 bg-amber-100 text-batik-brown rounded-2xl flex items-center justify-center mx-auto text-2xl"><i class="fa-solid fa-feather-pointed text-batik-gold"></i></div>
                <h3 class="font-serif text-lg font-bold text-gray-900">Batik Tulis</h3>
                <p class="text-xs text-gray-600 leading-relaxed">Dibuat sepenuhnya dengan canting tangan dan malam (lilin) panas. Proses pengerjaan memakan waktu berminggu-minggu hingga berbulan-bulan, menghasilkan karya yang benar-benar unik dan bernilai seni tinggi.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl border border-amber-100 shadow-sm text-center space-y-4 hover:shadow-lg transition">
                <div class="w-16 h-16 bg-amber-100 text-batik-brown rounded-2xl flex items-center justify-center mx-auto text-2xl"><i class="fa-solid fa-stamp text-batik-gold"></i></div>
                <h3 class="font-serif text-lg font-bold text-gray-900">Batik Cap</h3>
                <p class="text-xs text-gray-600 leading-relaxed">Menggunakan cap tembaga bermotif yang dicelupkan ke malam panas lalu dicapkan ke kain. Presisi tinggi dan konsistensi motif menjadikannya pilihan ideal untuk busana formal dan seragam.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl border border-amber-100 shadow-sm text-center space-y-4 hover:shadow-lg transition">
                <div class="w-16 h-16 bg-amber-100 text-batik-brown rounded-2xl flex items-center justify-center mx-auto text-2xl"><i class="fa-solid fa-wand-magic-sparkles text-batik-gold"></i></div>
                <h3 class="font-serif text-lg font-bold text-gray-900">Batik Kombinasi</h3>
                <p class="text-xs text-gray-600 leading-relaxed">Memadukan teknik cap untuk pola dasar dan sentuhan tulis tangan untuk detail halus. Menawarkan keseimbangan sempurna antara keunikan artistik dan harga yang terjangkau.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs uppercase tracking-widest text-batik-gold font-bold">Nilai-Nilai Kami</span>
            <h2 class="font-serif text-3xl font-bold text-gray-900 mt-2">Prinsip yang Kami Pegang Teguh</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['icon'=>'fa-certificate','title'=>'Keaslian','desc'=>'Setiap produk dijamin 100% batik asli tulis atau cap tradisional, bukan sablon printing massal.'],
                ['icon'=>'fa-gem','title'=>'Kualitas Premium','desc'=>'Bahan kain pilihan terbaik dengan jahitan rapi standar butik dan furing halus.'],
                ['icon'=>'fa-lightbulb','title'=>'Inovasi Desain','desc'=>'Memadukan motif klasik dengan potongan modern agar relevan untuk segala kesempatan.'],
                ['icon'=>'fa-leaf','title'=>'Pelestarian Budaya','desc'=>'Mendukung kesejahteraan perajin lokal dan menjaga kelestarian warisan budaya bangsa.'],
            ] as $v)
                <div class="p-6 bg-[#fdfbf7] rounded-2xl border border-amber-100 space-y-3 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-amber-100 text-batik-gold rounded-xl flex items-center justify-center text-xl"><i class="fa-solid {{ $v['icon'] }}"></i></div>
                    <h4 class="font-bold text-gray-900">{{ $v['title'] }}</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">{{ $v['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-16 bg-gradient-to-r from-amber-900 via-batik-brown to-amber-950 text-white text-center">
    <div class="max-w-3xl mx-auto px-4 space-y-6">
        <h2 class="font-serif text-3xl font-bold">Siap Menemukan Batik Impian Anda?</h2>
        <p class="text-amber-100 text-sm font-light">Jelajahi ratusan koleksi batik eksklusif dari para maestro perajin nusantara.</p>
        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold px-7 py-3.5 rounded-full shadow-lg transition">
            Jelajahi Katalog <i class="fa-solid fa-arrow-right text-sm"></i>
        </a>
    </div>
</section>
@endsection
