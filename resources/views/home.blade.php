@extends('layouts.app')

@section('title', 'Batik Gendis Ayu - Mahakarya Batik Nusantara Asli Yogyakarta')

@section('content')
<!-- Hero Section -->
<section class="relative bg-batik-pattern text-white py-20 lg:py-32 overflow-hidden border-b-4 border-batik-gold">
    <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/75 to-transparent z-10"></div>
    
    <!-- Background Hero Image -->
    <div class="absolute inset-0 z-0 opacity-40 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?q=80&w=1600&auto=format&fit=crop');"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
        <div class="max-w-2xl space-y-6">
            <div class="inline-flex items-center gap-2 bg-amber-500/20 border border-amber-400/40 px-3.5 py-1.5 rounded-full text-xs font-semibold text-amber-300">
                <i class="fa-solid fa-sparkles text-batik-gold"></i>
                <span>Koleksi Eksklusif Nusantara 2026</span>
            </div>

            <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight text-white">
                Pesona Keanggunan <br>
                <span class="text-batik-gold italic font-serif">Batik Tradisi Luhur</span>
            </h1>

            <p class="text-gray-300 text-base sm:text-lg leading-relaxed font-light">
                Selamat datang di <strong class="text-amber-200 font-medium">Batik Gendis Ayu</strong>. Setiap helai kain dirajut dengan dedikasi para maestro pembatik Yogyakarta & Solo, memadukan keaslian motif klasik dengan siluet modern berkelas tinggi.
            </p>

            <div class="pt-4 flex flex-wrap items-center gap-4">
                <a href="{{ route('shop.index') }}"
                   class="inline-flex items-center gap-3 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold px-7 py-3.5 rounded-full shadow-lg hover:shadow-amber-500/30 transition transform hover:-translate-y-0.5">
                    <span>Jelajahi Katalog</span>
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>
                <a href="{{ route('about') }}"
                   class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold px-6 py-3.5 rounded-full backdrop-blur-sm border border-white/20 transition">
                    <i class="fa-solid fa-circle-play text-batik-gold"></i>
                    <span>Filosofi & Proses</span>
                </a>
            </div>

            <!-- Stats Bar -->
            <div class="pt-8 grid grid-cols-3 gap-6 border-t border-gray-800">
                <div>
                    <span class="block font-serif text-2xl sm:text-3xl font-bold text-batik-gold">100%</span>
                    <span class="text-xs text-gray-400">Batik Asli Tulis & Cap</span>
                </div>
                <div>
                    <span class="block font-serif text-2xl sm:text-3xl font-bold text-batik-gold">500+</span>
                    <span class="text-xs text-gray-400">Koleksi Desain Motif</span>
                </div>
                <div>
                    <span class="block font-serif text-2xl sm:text-3xl font-bold text-batik-gold">4.9 / 5</span>
                    <span class="text-xs text-gray-400">Kepuasan Pelanggan</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Value Propositions / Keunggulan Toko -->
<section class="py-12 bg-white border-b border-amber-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#fdfbf7] border border-amber-100 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 text-batik-brown flex items-center justify-center text-2xl flex-shrink-0">
                    <i class="fa-solid fa-certificate text-batik-gold"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm">Batik Asli Bergaransi</h4>
                    <p class="text-xs text-gray-500 mt-0.5">Bukan printing sablon massal, kualitas motif teruji.</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#fdfbf7] border border-amber-100 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 text-batik-brown flex items-center justify-center text-2xl flex-shrink-0">
                    <i class="fa-solid fa-temperature-arrow-down text-batik-gold"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm">Furing Trikot Dingin</h4>
                    <p class="text-xs text-gray-500 mt-0.5">Lapis kain sejuk yang menyerap keringat seharian.</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#fdfbf7] border border-amber-100 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 text-batik-brown flex items-center justify-center text-2xl flex-shrink-0">
                    <i class="fa-solid fa-box-open text-batik-gold"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm">Stok Real-Time</h4>
                    <p class="text-xs text-gray-500 mt-0.5">Persediaan akurat langsung dari galeri pusat.</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#fdfbf7] border border-amber-100 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 text-batik-brown flex items-center justify-center text-2xl flex-shrink-0">
                    <i class="fa-solid fa-rotate-left text-batik-gold"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm">Garansi Retur Ukuran</h4>
                    <p class="text-xs text-gray-500 mt-0.5">Kekecilan atau cacat produksi siap kami ganti.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-[#f7f4ed]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs uppercase tracking-widest text-batik-gold font-bold">Koleksi Busana & Kain</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-gray-900 mt-2">Kategori Pilihan Batik Nusantara</h2>
            <div class="w-16 h-1 bg-batik-gold mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
            @foreach($categories as $category)
                <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                   class="group relative rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-xl transition duration-300 transform hover:-translate-y-1 border border-amber-100">
                    <div class="aspect-[4/5] overflow-hidden bg-gray-100">
                        <img src="{{ $category->image ?: 'https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?q=80&w=600&auto=format&fit=crop' }}"
                             alt="{{ $category->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 p-4 text-white">
                        <h3 class="font-serif font-bold text-sm sm:text-base leading-tight group-hover:text-amber-300 transition">
                            {{ $category->name }}
                        </h3>
                        <p class="text-[11px] text-gray-300 mt-1 font-light">
                            {{ $category->products_count }} Koleksi
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products (Unggulan) -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-12 gap-4">
            <div>
                <span class="text-xs uppercase tracking-widest text-batik-gold font-bold">Koleksi Mahakarya</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-gray-900 mt-1">Produk Unggulan Batik Gendis Ayu</h2>
            </div>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-batik-gold hover:text-amber-700 transition">
                <span>Lihat Seluruh Katalog</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            @foreach($featuredProducts as $product)
                <div class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 flex flex-col">
                    <!-- Product Image & Badges -->
                    <div class="relative aspect-[3/4] overflow-hidden bg-gray-100">
                        <a href="{{ route('shop.show', $product->slug) }}">
                            <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?q=80&w=600&auto=format&fit=crop' }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </a>

                        <!-- Stock Badge -->
                        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                            @if($product->total_stock <= 0)
                                <span class="bg-rose-600 text-white text-[11px] font-bold px-2.5 py-1 rounded-full shadow-sm">
                                    Stok Habis
                                </span>
                            @elseif($product->total_stock <= $product->min_stock)
                                <span class="bg-amber-500 text-gray-900 text-[11px] font-bold px-2.5 py-1 rounded-full shadow-sm">
                                    Sisa {{ $product->total_stock }} pcs!
                                </span>
                            @else
                                <span class="bg-emerald-600 text-white text-[11px] font-semibold px-2.5 py-1 rounded-full shadow-sm">
                                    Tersedia
                                </span>
                            @endif

                            <span class="bg-black/60 backdrop-blur-sm text-amber-200 text-[10px] font-medium px-2 py-0.5 rounded-full">
                                {{ $product->category->name }}
                            </span>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            @if($product->motif)
                                <div class="text-[11px] font-bold uppercase tracking-wider text-batik-gold">
                                    Motif: {{ $product->motif }}
                                </div>
                            @endif
                            <h3 class="font-medium text-gray-900 text-sm hover:text-batik-gold transition mt-1 line-clamp-2">
                                <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                        </div>

                        <div>
                            <div class="text-xs text-gray-500 mb-2">
                                Bahan: <span class="font-medium text-gray-700">{{ $product->material ?? 'Katun Primisima' }}</span>
                            </div>

                            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                <div>
                                    <span class="text-xs text-gray-400 block">Harga</span>
                                    <span class="text-base font-bold text-amber-900">{{ $product->formatted_price }}</span>
                                </div>
                                <a href="{{ route('shop.show', $product->slug) }}"
                                   class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-amber-50 text-batik-brown hover:bg-batik-gold hover:text-white transition shadow-sm"
                                   title="Pilih Ukuran & Pesan">
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Banner Edukasi: Warisan Budaya & Filosofi Batik -->
<section class="py-16 bg-[#1b1d22] text-white border-y border-amber-900/40 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <span class="text-xs uppercase tracking-widest text-batik-gold font-bold">Adiluhung Warisan Dunia UNESCO</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold leading-tight">
                    Setiap Goresan Canting <br>
                    <span class="text-amber-300 italic font-serif">Menyimpan Doa & Filosofi Luhur</span>
                </h2>
                <p class="text-gray-300 text-sm sm:text-base leading-relaxed font-light">
                    Batik bukan sekadar corak pada kain, melainkan doa, harapan, dan kearifan hidup para leluhur. Di <strong>Batik Gendis Ayu</strong>, kami merawat keaslian proses canting tangan (batik tulis) dan canting tembaga (batik cap) dengan pewarnaan alami yang ramah lingkungan.
                </p>

                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="bg-white/5 border border-amber-500/20 p-4 rounded-xl">
                        <h4 class="font-bold text-amber-300 text-sm mb-1"><i class="fa-solid fa-feather-pointed mr-1.5"></i> Batik Tulis Canting</h4>
                        <p class="text-xs text-gray-400">Dikerjakan berbulan-bulan dengan konsentrasi tinggi, menghasilkan karya eksklusif satu-satunya.</p>
                    </div>
                    <div class="bg-white/5 border border-amber-500/20 p-4 rounded-xl">
                        <h4 class="font-bold text-amber-300 text-sm mb-1"><i class="fa-solid fa-stamp mr-1.5"></i> Batik Cap Tembaga</h4>
                        <p class="text-xs text-gray-400">Presisi tinggi dengan malam panas alami, menghasilkan kerapian motif khas keraton Solo & Jogja.</p>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ route('about') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-batik-gold hover:text-amber-300 transition">
                        <span>Baca Cerita Galeri & Panduan Memilih Motif</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Image collage -->
            <div class="relative">
                <div class="aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl border-2 border-amber-500/30">
                    <img src="https://images.unsplash.com/photo-1590736969955-71cc94801759?q=80&w=800&auto=format&fit=crop"
                         alt="Proses Membatik Tulis Tradisional"
                         class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-6 -left-6 bg-batik-brown text-amber-200 p-5 rounded-2xl shadow-xl border border-batik-gold/50 hidden sm:block max-w-xs">
                    <div class="flex items-center gap-3 mb-1">
                        <i class="fa-solid fa-location-dot text-batik-gold text-lg"></i>
                        <span class="font-bold text-sm text-white">Galeri Malioboro</span>
                    </div>
                    <p class="text-xs text-amber-100/80">Kunjungi langsung galeri kami di pusat kebudayaan Yogyakarta.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Arrivals Section -->
<section class="py-16 bg-[#fdfbf7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs uppercase tracking-widest text-batik-gold font-bold">Keluaran Terbaru</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-gray-900 mt-2">Koleksi Terkini Minggu Ini</h2>
            <p class="text-xs text-gray-500 mt-2">Dapatkan motif langka sebelum kehabisan stok persediaan.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latestProducts as $product)
                <div class="bg-white rounded-2xl overflow-hidden border border-amber-100 shadow-sm hover:shadow-md transition flex flex-col">
                    <a href="{{ route('shop.show', $product->slug) }}" class="aspect-[3/4] overflow-hidden bg-gray-50 relative">
                        <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?q=80&w=600&auto=format&fit=crop' }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur-sm text-gray-800 text-[10px] font-semibold px-2 py-0.5 rounded shadow-sm">
                            SKU: {{ $product->sku }}
                        </div>
                    </a>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-batik-gold">{{ $product->category->name }}</span>
                            <h4 class="font-medium text-gray-900 text-sm mt-0.5 line-clamp-1 hover:text-batik-gold transition">
                                <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                            </h4>
                        </div>
                        <div class="mt-3 flex items-center justify-between pt-2 border-t border-gray-50">
                            <span class="text-sm font-bold text-gray-900">{{ $product->formatted_price }}</span>
                            <a href="{{ route('shop.show', $product->slug) }}" class="text-xs text-amber-700 hover:text-amber-900 font-semibold">
                                Detail &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call To Action -->
<section class="py-16 bg-gradient-to-r from-amber-900 via-batik-brown to-amber-950 text-white text-center relative">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <h2 class="font-serif text-3xl sm:text-4xl font-bold">
            Butuh Seragam Batik Kantor atau Resepsi Keluarga?
        </h2>
        <p class="text-amber-100 text-sm sm:text-base font-light max-w-2xl mx-auto">
            Batik Gendis Ayu menerima pemesanan khusus kain seragam, jahit kustom ukuran, serta pembuatan hampers batik eksklusif berlogo instansi dengan harga pengrajin langsung.
        </p>
        <div class="pt-4 flex flex-wrap justify-center gap-4">
            <a href="https://wa.me/6281234567890?text=Halo%20Batik%20Gendis%20Ayu,%20saya%20ingin%20konsultasi%20pemesanan%20seragam%20batik" target="_blank"
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-7 py-3.5 rounded-full shadow-lg transition">
                <i class="fa-brands fa-whatsapp text-lg"></i>
                <span>Hubungi Kami via WhatsApp</span>
            </a>
            <a href="{{ route('shop.index') }}"
               class="inline-flex items-center gap-2 bg-white text-gray-900 hover:bg-amber-50 font-bold px-7 py-3.5 rounded-full shadow-lg transition">
                <span>Lihat Seluruh Koleksi</span>
            </a>
        </div>
    </div>
</section>
@endsection
