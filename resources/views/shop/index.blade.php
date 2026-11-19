@extends('layouts.app')

@section('title', 'Katalog Batik Nusantara - Batik Gendis Ayu')

@section('content')
<!-- Page Header -->
<div class="bg-[#1b1d22] text-white py-12 border-b-2 border-batik-gold">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="text-xs uppercase tracking-widest text-batik-gold font-bold">Koleksi Busana & Kain</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold mt-1">Katalog Produk Batik Gendis Ayu</h1>
            <p class="text-gray-300 text-sm mt-2 font-light">
                Jelajahi keindahan batik tulis, cap, kemeja pria, blouse wanita, kain jarik, dan sarimbit keluarga dengan sistem stok persediaan real-time.
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Filter Sidebar -->
        <aside class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-amber-100 space-y-6 sticky top-28">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <h3 class="font-serif text-base font-bold text-gray-900">
                        <i class="fa-solid fa-sliders text-batik-gold mr-2"></i> Filter Katalog
                    </h3>
                    @if(request()->hasAny(['q', 'category', 'motif', 'sort', 'min_price', 'max_price']))
                        <a href="{{ route('shop.index') }}" class="text-xs text-rose-600 hover:underline">Reset</a>
                    @endif
                </div>

                <form method="GET" action="{{ route('shop.index') }}" class="space-y-6">
                    <!-- Search Input -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Cari Produk / Motif</label>
                        <div class="relative">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Misal: Parang, Katun..."
                                   class="w-full text-sm pl-9 pr-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-xs"></i>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori Batik</label>
                        <div class="space-y-1.5 max-h-48 overflow-y-auto text-sm">
                            <label class="flex items-center gap-2 cursor-pointer hover:text-batik-gold">
                                <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }}
                                       onchange="this.form.submit()" class="text-amber-600 focus:ring-amber-500">
                                <span class="text-xs text-gray-700">Semua Kategori</span>
                            </label>
                            @foreach($categories as $cat)
                                <label class="flex items-center justify-between cursor-pointer hover:text-batik-gold">
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }}
                                               onchange="this.form.submit()" class="text-amber-600 focus:ring-amber-500">
                                        <span class="text-xs text-gray-700">{{ $cat->name }}</span>
                                    </div>
                                    <span class="text-[10px] text-gray-400">({{ $cat->products_count }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Motif Filter -->
                    @if($motifs->count() > 0)
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Motif Klasik</label>
                            <select name="motif" onchange="this.form.submit()"
                                    class="w-full text-xs py-2 px-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none bg-white">
                                <option value="">Semua Motif</option>
                                @foreach($motifs as $m)
                                    <option value="{{ $m }}" {{ request('motif') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Sorting -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Urutkan Berdasarkan</label>
                        <select name="sort" onchange="this.form.submit()"
                                class="w-full text-xs py-2 px-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none bg-white">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru Dirilis</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Terendah ke Tertinggi</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tertinggi ke Terendah</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama Produk (A-Z)</option>
                        </select>
                    </div>

                    <button type="submit"
                            class="w-full bg-batik-brown text-batik-gold hover:bg-batik-dark py-2.5 rounded-xl font-semibold text-xs tracking-wider uppercase transition shadow-sm">
                        Terapkan Filter
                    </button>
                </form>
            </div>
        </aside>

        <!-- Product Grid -->
        <main class="lg:col-span-3">
            <div class="flex items-center justify-between mb-6 bg-white p-4 rounded-xl border border-amber-100/60 shadow-sm">
                <p class="text-xs text-gray-500">
                    Menampilkan <span class="font-bold text-gray-800">{{ $products->total() }}</span> produk batik nusantara
                </p>
                <div class="text-xs text-gray-500 hidden sm:block">
                    Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}
                </div>
            </div>

            @if($products->isEmpty())
                <div class="bg-white rounded-2xl p-12 text-center border border-dashed border-amber-200">
                    <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mx-auto text-batik-gold text-2xl mb-4">
                        <i class="fa-solid fa-shirt"></i>
                    </div>
                    <h3 class="font-serif text-lg font-bold text-gray-800">Tidak ada produk batik yang cocok</h3>
                    <p class="text-xs text-gray-500 max-w-md mx-auto mt-1 mb-6">
                        Coba gunakan kata kunci lain, atau hapus filter kategori untuk melihat seluruh mahakarya batik kami.
                    </p>
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-batik-gold text-gray-900 font-bold px-5 py-2.5 rounded-full text-xs">
                        Lihat Seluruh Koleksi
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 flex flex-col">
                            <!-- Image Container -->
                            <div class="relative aspect-[3/4] overflow-hidden bg-gray-100">
                                <a href="{{ route('shop.show', $product->slug) }}">
                                    <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?q=80&w=600&auto=format&fit=crop' }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                </a>

                                <!-- Stock Status Badges -->
                                <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                    @if($product->total_stock <= 0)
                                        <span class="bg-rose-600 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow">
                                            Habis
                                        </span>
                                    @elseif($product->total_stock <= $product->min_stock)
                                        <span class="bg-amber-500 text-gray-900 text-[10px] font-bold px-2 py-0.5 rounded shadow">
                                            Sisa {{ $product->total_stock }} pcs
                                        </span>
                                    @else
                                        <span class="bg-emerald-600 text-white text-[10px] font-semibold px-2 py-0.5 rounded shadow">
                                            Stok Tersedia
                                        </span>
                                    @endif

                                    <span class="bg-black/60 backdrop-blur-sm text-white text-[10px] font-medium px-2 py-0.5 rounded">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                                <div>
                                    @if($product->motif)
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-batik-gold block">
                                            Motif: {{ $product->motif }}
                                        </span>
                                    @endif
                                    <h3 class="font-medium text-gray-900 text-sm hover:text-batik-gold transition mt-0.5 line-clamp-2">
                                        <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                                    </h3>
                                    <p class="text-xs text-gray-400 mt-1 line-clamp-1 font-light">
                                        {{ $product->material ?? 'Katun Primisima' }} • {{ $product->technique ?? 'Batik Cap' }}
                                    </p>
                                </div>

                                <div>
                                    <!-- Variants preview -->
                                    <div class="flex items-center gap-1.5 mb-3 flex-wrap">
                                        <span class="text-[10px] text-gray-400 mr-1">Ukuran:</span>
                                        @foreach($product->variants as $var)
                                            <span class="text-[10px] font-medium px-2 py-0.5 rounded {{ $var->stock > 0 ? 'bg-amber-50 text-amber-900 border border-amber-200' : 'bg-gray-100 text-gray-400 line-through' }}">
                                                {{ $var->size }}
                                            </span>
                                        @endforeach
                                    </div>

                                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                        <div>
                                            <span class="text-[10px] text-gray-400 block uppercase">Harga</span>
                                            <span class="text-base font-bold text-amber-900">{{ $product->formatted_price }}</span>
                                        </div>
                                        <a href="{{ route('shop.show', $product->slug) }}"
                                           class="inline-flex items-center gap-1 bg-amber-50 text-batik-brown hover:bg-batik-gold hover:text-white px-3 py-1.5 rounded-full text-xs font-semibold transition">
                                            <span>Detail</span>
                                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
