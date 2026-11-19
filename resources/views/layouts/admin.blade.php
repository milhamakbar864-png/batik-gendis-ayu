<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Batik Gendis Ayu</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    
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
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800 min-h-screen flex antialiased" x-data="{ sidebarOpen: false }">

    <!-- Sidebar Overlay for Mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
         class="fixed inset-0 z-40 bg-gray-900/60 lg:hidden transition-opacity"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-50 w-72 bg-[#1b1d22] text-gray-300 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-xl border-r border-amber-900/40">
        
        <!-- Sidebar Brand Header -->
        <div class="h-20 px-6 flex items-center justify-between border-b border-gray-800 bg-[#16171b]">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-batik-brown flex items-center justify-center text-batik-gold border border-batik-gold">
                    <i class="fa-solid fa-feather-pointed"></i>
                </div>
                <div>
                    <span class="font-serif text-lg font-bold text-white tracking-wide block leading-none">Batik Gendis Ayu</span>
                    <span class="text-[10px] text-amber-300 tracking-wider font-semibold uppercase">Admin & Persediaan</span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Sidebar Navigation Menu -->
        <div class="flex-1 overflow-y-auto py-5 px-4 space-y-1 text-sm">
            <div class="text-[11px] font-bold uppercase tracking-wider text-gray-400 px-3 pb-2 pt-1">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500/20 text-amber-300 font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-gauge-high w-5 text-center text-batik-gold"></i>
                <span>Dashboard Utama</span>
            </a>

            <!-- Orders Management -->
            @php
                $pendingOrderCount = \App\Models\Order::where('payment_status', 'pending_verification')->count();
            @endphp
            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('admin.orders.*') ? 'bg-amber-500/20 text-amber-300 font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-cart-shopping w-5 text-center text-batik-gold"></i>
                    <span>Pesanan & Transaksi</span>
                </div>
                @if($pendingOrderCount > 0)
                    <span class="bg-amber-500 text-gray-900 text-xs font-bold px-2 py-0.5 rounded-full" title="Verifikasi Pembayaran">
                        {{ $pendingOrderCount }}
                    </span>
                @endif
            </a>

            <div class="text-[11px] font-bold uppercase tracking-wider text-gray-400 px-3 pb-2 pt-5">Katalog & Produk</div>

            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('admin.categories.*') ? 'bg-amber-500/20 text-amber-300 font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-tags w-5 text-center text-batik-gold"></i>
                <span>Kategori Batik</span>
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('admin.products.*') ? 'bg-amber-500/20 text-amber-300 font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-shirt w-5 text-center text-batik-gold"></i>
                <span>Daftar Produk Batik</span>
            </a>

            <div class="text-[11px] font-bold uppercase tracking-wider text-gray-400 px-3 pb-2 pt-5">Inti Persediaan (Inventory)</div>

            <a href="{{ route('admin.inventory.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('admin.inventory.index') ? 'bg-amber-500/20 text-amber-300 font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-boxes-stacked w-5 text-center text-batik-gold"></i>
                <span>Monitoring Stok</span>
            </a>

            <a href="{{ route('admin.inventory.stockIn') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('admin.inventory.stockIn') ? 'bg-amber-500/20 text-amber-300 font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-arrow-down-long w-5 text-center text-emerald-400"></i>
                <span>Barang Masuk (Restock)</span>
            </a>

            <a href="{{ route('admin.inventory.stockOut') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('admin.inventory.stockOut') ? 'bg-amber-500/20 text-amber-300 font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-arrow-up-long w-5 text-center text-rose-400"></i>
                <span>Barang Keluar (Retur/Rusak)</span>
            </a>

            <a href="{{ route('admin.inventory.movements') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('admin.inventory.movements') ? 'bg-amber-500/20 text-amber-300 font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-clipboard-list w-5 text-center text-blue-400"></i>
                <span>Kartu Stok & Mutasi</span>
            </a>

            @php
                $alertCount = \App\Models\Product::with('variants')->get()->filter(fn($p) => $p->total_stock <= $p->min_stock)->count();
            @endphp
            <a href="{{ route('admin.inventory.alerts') }}"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('admin.inventory.alerts') ? 'bg-amber-500/20 text-amber-300 font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation w-5 text-center text-amber-400"></i>
                    <span>Peringatan Stok Kritis</span>
                </div>
                @if($alertCount > 0)
                    <span class="bg-rose-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                        {{ $alertCount }}
                    </span>
                @endif
            </a>

            <div class="text-[11px] font-bold uppercase tracking-wider text-gray-400 px-3 pb-2 pt-5">Laporan (Skripsi)</div>

            <a href="{{ route('admin.reports.sales') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('admin.reports.sales') ? 'bg-amber-500/20 text-amber-300 font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-file-invoice-dollar w-5 text-center text-batik-gold"></i>
                <span>Laporan Penjualan & Laba</span>
            </a>

            <a href="{{ route('admin.reports.inventory') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('admin.reports.inventory') ? 'bg-amber-500/20 text-amber-300 font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center text-batik-gold"></i>
                <span>Laporan Nilai Persediaan</span>
            </a>

            <div class="text-[11px] font-bold uppercase tracking-wider text-gray-400 px-3 pb-2 pt-5">Konfigurasi</div>

            <a href="{{ route('admin.settings.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('admin.settings.*') ? 'bg-amber-500/20 text-amber-300 font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-sliders w-5 text-center text-batik-gold"></i>
                <span>Pengaturan Galeri & Bank</span>
            </a>
        </div>

        <!-- Sidebar Bottom Footer User Info -->
        <div class="p-4 border-t border-gray-800 bg-[#16171b]">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 truncate">
                    <div class="w-9 h-9 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="truncate text-xs">
                        <p class="font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-gray-500">Administrator</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-rose-400 p-2 transition" title="Keluar">
                        <i class="fa-solid fa-power-off"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Top Admin Header Bar -->
        <header class="bg-white border-b border-gray-200 h-20 flex items-center justify-between px-4 sm:px-6 lg:px-8 no-print">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-600 hover:text-gray-900 p-2">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <div>
                    <h1 class="text-xl font-bold text-gray-800 leading-tight">@yield('page_title', 'Dashboard')</h1>
                    <p class="text-xs text-gray-500">Sistem Penjualan Online & Manajemen Persediaan Batik Gendis Ayu</p>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Shortcut to View Public Website -->
                <a href="{{ route('home') }}" target="_blank"
                   class="inline-flex items-center gap-2 text-xs font-semibold bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 px-3.5 py-2 rounded-lg transition shadow-sm">
                    <i class="fa-solid fa-arrow-up-right-from-square text-batik-gold"></i>
                    <span class="hidden sm:inline">Lihat Toko Online</span>
                </a>

                <!-- Notification Bell -->
                <div class="relative">
                    <a href="{{ route('admin.inventory.alerts') }}" class="p-2 text-gray-500 hover:text-amber-600 transition relative block">
                        <i class="fa-regular fa-bell text-xl"></i>
                        @if($alertCount > 0)
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-rose-500 rounded-full animate-ping"></span>
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-rose-500 rounded-full"></span>
                        @endif
                    </a>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-4 sm:px-6 lg:px-8 pt-4 no-print">
            @if(session('success'))
                <div class="p-4 mb-3 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between shadow-sm">
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
                <div class="p-4 mb-3 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-between shadow-sm">
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
                <div class="p-4 mb-3 text-sm text-amber-800 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-between shadow-sm">
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
                <div class="p-4 mb-3 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200 shadow-sm">
                    <div class="flex items-center gap-2 font-semibold mb-1">
                        <i class="fa-solid fa-circle-exclamation text-rose-600"></i>
                        <span>Terdapat kesalahan input:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 ml-4 text-rose-700">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Admin Content Body -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
