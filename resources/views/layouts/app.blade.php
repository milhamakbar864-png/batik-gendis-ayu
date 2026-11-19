<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Batik Gendis Ayu - Pesona Keanggunan Batik Nusantara')</title>
    <meta name="description" content="Toko online resmi Batik Gendis Ayu Yogyakarta. Menyediakan koleksi batik tulis, cap, kemeja pria, blouse wanita, kain jarik, dan busana sarimbit berkualitas premium.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        batik: {
                            gold: '#c59b27',
                            goldHover: '#b38a1f',
                            dark: '#1b1d22',
                            brown: '#3e2723',
                            cream: '#fdfbf7',
                            warmGray: '#f7f4ed',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        .bg-batik-pattern {
            background-color: #1b1d22;
            background-image: radial-gradient(rgba(197, 155, 39, 0.15) 1px, transparent 0);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-[#fdfbf7] min-h-screen flex flex-col" x-data="{ mobileMenu: false }">

    <!-- Top Announcement Bar -->
    <div class="bg-batik-dark text-amber-200 text-xs py-2 px-4 border-b border-amber-900/40">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span><i class="fa-solid fa-gem text-batik-gold mr-1.5"></i> 100% Batik Nusantara Asli (Tulis & Cap Tradisional)</span>
                <span class="hidden md:inline text-amber-200/50">•</span>
                <span class="hidden md:inline"><i class="fa-solid fa-shield-halved mr-1 text-batik-gold"></i> Bergaransi Retur Jika Cacat</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('order.track') }}" class="hover:text-white transition flex items-center gap-1.5">
                    <i class="fa-solid fa-truck-fast text-batik-gold"></i> Lacak Pesanan
                </a>
                <span class="text-amber-200/50">•</span>
                <a href="https://wa.me/6281234567890" target="_blank" class="hover:text-white transition flex items-center gap-1">
                    <i class="fa-brands fa-whatsapp text-emerald-400"></i> WhatsApp: 0812-3456-7890
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="bg-white sticky top-0 z-40 shadow-sm border-b border-amber-100/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-full bg-batik-brown flex items-center justify-center text-batik-gold border-2 border-batik-gold shadow-sm group-hover:scale-105 transition">
                        <i class="fa-solid fa-feather-pointed text-xl"></i>
                    </div>
                    <div>
                        <span class="font-serif text-2xl font-bold tracking-wide text-batik-brown block leading-none">Batik Gendis Ayu</span>
                        <span class="text-[10px] uppercase tracking-widest text-batik-gold font-semibold">Yogyakarta • Sejak 2018</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-semibold transition {{ request()->routeIs('home') ? 'text-batik-gold border-b-2 border-batik-gold pb-1' : 'text-gray-700 hover:text-batik-gold' }}">
                        Beranda
                    </a>
                    <a href="{{ route('shop.index') }}" class="text-sm font-semibold transition {{ request()->routeIs('shop.*') ? 'text-batik-gold border-b-2 border-batik-gold pb-1' : 'text-gray-700 hover:text-batik-gold' }}">
                        Katalog Batik
                    </a>
                    <a href="{{ route('about') }}" class="text-sm font-semibold transition {{ request()->routeIs('about') ? 'text-batik-gold border-b-2 border-batik-gold pb-1' : 'text-gray-700 hover:text-batik-gold' }}">
                        Tentang Kami
                    </a>
                    <a href="{{ route('contact') }}" class="text-sm font-semibold transition {{ request()->routeIs('contact') ? 'text-batik-gold border-b-2 border-batik-gold pb-1' : 'text-gray-700 hover:text-batik-gold' }}">
                        Kontak & Galeri
                    </a>
                    <a href="{{ route('order.track') }}" class="text-sm font-semibold transition {{ request()->routeIs('order.track') ? 'text-batik-gold border-b-2 border-batik-gold pb-1' : 'text-gray-700 hover:text-batik-gold' }}">
                        Lacak Pesanan
                    </a>
                </nav>

                <!-- Right Action Icons -->
                <div class="flex items-center space-x-3 sm:space-x-5">
                    <!-- Search Link -->
                    <a href="{{ route('shop.index') }}" class="text-gray-600 hover:text-batik-gold p-2 transition" title="Cari Motif & Produk">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </a>

                    <!-- Shopping Cart Icon with Badge -->
                    @php
                        $cartCount = array_sum(array_column(session('cart', []), 'quantity'));
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-batik-gold p-2 transition" title="Keranjang Belanja">
                        <i class="fa-solid fa-bag-shopping text-xl"></i>
                        @if($cartCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-amber-600 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- User Account / Login -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-batik-gold focus:outline-none bg-amber-50 py-1.5 px-3 rounded-full border border-amber-200">
                                <i class="fa-regular fa-circle-user text-batik-gold text-lg"></i>
                                <span class="hidden sm:inline max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                            </button>

                            <div x-show="open" @click.outside="open = false" x-cloak
                                 class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-amber-100 py-2 z-50 animate-fade-in">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-xs text-gray-500">Masuk sebagai</p>
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold rounded {{ auth()->user()->isAdmin() ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ auth()->user()->isAdmin() ? 'Administrator' : 'Pelanggan' }}
                                    </span>
                                </div>

                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-batik-gold">
                                        <i class="fa-solid fa-chart-line w-5 text-batik-gold"></i> Panel Admin
                                    </a>
                                @else
                                    <a href="{{ route('customer.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-batik-gold">
                                        <i class="fa-solid fa-box-open w-5 text-batik-gold"></i> Pesanan Saya
                                    </a>
                                    <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-batik-gold">
                                        <i class="fa-regular fa-user w-5 text-batik-gold"></i> Pengaturan Akun
                                    </a>
                                @endif

                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 flex items-center">
                                        <i class="fa-solid fa-arrow-right-from-bracket w-5 text-rose-500"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-batik-brown text-batik-gold hover:bg-batik-dark font-medium text-sm px-4 py-2 rounded-full border border-batik-gold/40 transition shadow-sm">
                            <i class="fa-regular fa-user"></i>
                            <span>Masuk</span>
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenu = !mobileMenu" class="lg:hidden text-gray-700 hover:text-batik-gold p-2">
                        <i class="fa-solid fa-bars text-xl" x-show="!mobileMenu"></i>
                        <i class="fa-solid fa-xmark text-xl" x-show="mobileMenu" x-cloak></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenu" x-cloak class="lg:hidden bg-white border-b border-amber-100 px-4 pt-2 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block py-2 text-base font-medium text-gray-800 hover:text-batik-gold border-b border-gray-50">Beranda</a>
            <a href="{{ route('shop.index') }}" class="block py-2 text-base font-medium text-gray-800 hover:text-batik-gold border-b border-gray-50">Katalog Batik</a>
            <a href="{{ route('about') }}" class="block py-2 text-base font-medium text-gray-800 hover:text-batik-gold border-b border-gray-50">Tentang Kami</a>
            <a href="{{ route('contact') }}" class="block py-2 text-base font-medium text-gray-800 hover:text-batik-gold border-b border-gray-50">Kontak & Galeri</a>
            <a href="{{ route('order.track') }}" class="block py-2 text-base font-medium text-gray-800 hover:text-batik-gold">Lacak Pesanan</a>
        </div>
    </header>

    <!-- Flash Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between shadow-sm animate-fade-in" role="alert">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-between shadow-sm" role="alert">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('warning'))
            <div class="p-4 mb-4 text-sm text-amber-800 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-between shadow-sm" role="alert">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-amber-600 text-lg"></i>
                    <span>{{ session('warning') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-amber-500 hover:text-amber-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 mb-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200 shadow-sm" role="alert">
                <div class="flex items-center gap-2 font-semibold mb-1">
                    <i class="fa-solid fa-circle-exclamation text-rose-600"></i>
                    <span>Terdapat beberapa kesalahan input:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-0.5 ml-4 text-rose-700">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Page Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Floating WhatsApp Shortcut -->
    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Batik%20Gendis%20Ayu,%20saya%20tertarik%20dengan%20koleksi%20batik%20Anda" target="_blank"
       class="fixed bottom-6 right-6 bg-emerald-600 hover:bg-emerald-700 text-white p-3.5 rounded-full shadow-xl flex items-center justify-center z-50 group hover:scale-110 transition duration-300">
        <i class="fa-brands fa-whatsapp text-2xl"></i>
        <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs transition-all duration-300 ease-in-out px-0 group-hover:px-2 text-sm font-medium">Konsultasi Batik</span>
    </a>

    <!-- Footer -->
    <footer class="bg-batik-dark text-gray-300 pt-16 pb-8 border-t-4 border-batik-gold">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-gray-800">
                <!-- Column 1: Store Bio -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-batik-brown flex items-center justify-center text-batik-gold border border-batik-gold">
                            <i class="fa-solid fa-feather-pointed"></i>
                        </div>
                        <span class="font-serif text-2xl font-bold text-white tracking-wide">Batik Gendis Ayu</span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Galeri mahakarya batik nusantara asli Yogyakarta. Menghadirkan batik tulis dan cap berkelas tinggi dengan filosofi budaya adiluhung untuk mempercantik penampilan Anda.
                    </p>
                    <div class="flex space-x-3 text-batik-gold pt-2">
                        <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-batik-gold hover:text-batik-dark transition flex items-center justify-center"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-batik-gold hover:text-batik-dark transition flex items-center justify-center"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-batik-gold hover:text-batik-dark transition flex items-center justify-center"><i class="fa-brands fa-tiktok"></i></a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div>
                    <h4 class="font-serif text-lg font-semibold text-white mb-4 border-b border-amber-900/60 pb-2">Kategori Pilihan</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('shop.index', ['category' => 'kemeja-batik-pria']) }}" class="hover:text-batik-gold transition">Kemeja Batik Pria Formal</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'blouse-tunik-wanita']) }}" class="hover:text-batik-gold transition">Blouse & Tunik Anggun</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'batik-tulis-sutra-eksklusif']) }}" class="hover:text-batik-gold transition">Batik Tulis Sutra ATBM</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'kain-panjang-jarik']) }}" class="hover:text-batik-gold transition">Kain Jarik Tradisional</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'sarimbit-couple-series']) }}" class="hover:text-batik-gold transition">Sarimbit / Batik Pasangan</a></li>
                    </ul>
                </div>

                <!-- Column 3: Layanan Pelanggan -->
                <div>
                    <h4 class="font-serif text-lg font-semibold text-white mb-4 border-b border-amber-900/60 pb-2">Layanan & Panduan</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('order.track') }}" class="hover:text-batik-gold transition">Lacak Status Pesanan</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-batik-gold transition">Tentang Filosofi Motif Batik</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-batik-gold transition">Panduan Ukuran (Size Chart)</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-batik-gold transition">Garansi & Kebijakan Retur</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-batik-gold transition">Pemesanan Seragam Custom</a></li>
                    </ul>
                </div>

                <!-- Column 4: Galeri & Kontak -->
                <div>
                    <h4 class="font-serif text-lg font-semibold text-white mb-4 border-b border-amber-900/60 pb-2">Galeri Batik</h4>
                    <div class="space-y-3 text-sm text-gray-400">
                        <p class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot text-batik-gold mt-1"></i>
                            <span>Jl. Malioboro No. 45, Gedongtengen, Kota Yogyakarta, D.I. Yogyakarta 55271</span>
                        </p>
                        <p class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-batik-gold"></i>
                            <span>0812-3456-7890</span>
                        </p>
                        <p class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-batik-gold"></i>
                            <span>info@batikgendisayu.com</span>
                        </p>
                        <p class="flex items-center gap-2.5">
                            <i class="fa-solid fa-clock text-batik-gold"></i>
                            <span>Senin - Minggu: 09.00 - 21.00 WIB</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bottom Subfooter -->
            <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-gray-500 gap-4">
                <p>&copy; {{ date('Y') }} Batik Gendis Ayu. Sistem Penjualan Online & Manajemen Persediaan Berbasis Web (Skripsi - Metode Waterfall).</p>
                <div class="flex items-center gap-4 text-gray-400">
                    <span>Metode Pembayaran: BCA, Mandiri, BRI, QRIS</span>
                    <span>•</span>
                    <span>Jasa Kirim: JNE, J&T, SiCepat, POS</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
