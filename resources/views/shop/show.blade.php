@extends('layouts.app')

@section('title', $product->name . ' - Batik Gendis Ayu')

@section('content')
<!-- Breadcrumbs -->
<div class="bg-white border-b border-gray-100 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-xs text-gray-500 space-x-2">
            <a href="{{ route('home') }}" class="hover:text-batik-gold">Beranda</a>
            <span>/</span>
            <a href="{{ route('shop.index') }}" class="hover:text-batik-gold">Katalog</a>
            <span>/</span>
            <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-batik-gold">{{ $product->category->name }}</a>
            <span>/</span>
            <span class="text-gray-800 font-medium truncate max-w-xs">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
     x-data="{ 
        selectedVariantId: '{{ $product->variants->firstWhere('stock', '>', 0)?->id ?? $product->variants->first()?->id }}',
        selectedSize: '{{ $product->variants->firstWhere('stock', '>', 0)?->size ?? $product->variants->first()?->size }}',
        stockAvailable: {{ $product->variants->firstWhere('stock', '>', 0)?->stock ?? $product->variants->first()?->stock ?? 0 }},
        quantity: 1,
        variants: {{ $product->variants->toJson() }},
        selectVariant(v) {
            this.selectedVariantId = v.id;
            this.selectedSize = v.size;
            this.stockAvailable = v.stock;
            if (this.quantity > v.stock && v.stock > 0) {
                this.quantity = v.stock;
            }
        }
     }">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        <!-- Product Images -->
        <div class="space-y-4">
            <div class="aspect-[4/5] rounded-3xl overflow-hidden bg-gray-100 border border-amber-100 shadow-md relative">
                <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?q=80&w=800&auto=format&fit=crop' }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover">
                
                @if($product->total_stock <= 0)
                    <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px] flex items-center justify-center">
                        <span class="bg-rose-600 text-white font-bold text-sm px-5 py-2 rounded-full uppercase tracking-widest shadow-xl">
                            Stok Habis
                        </span>
                    </div>
                @endif
            </div>

            <!-- Guarantee Badges -->
            <div class="grid grid-cols-3 gap-3 pt-2 text-center text-xs text-gray-600">
                <div class="p-3 bg-white rounded-xl border border-amber-100/80">
                    <i class="fa-solid fa-stamp text-batik-gold text-base mb-1 block"></i>
                    <span class="font-medium text-gray-800">100% Asli Tulis/Cap</span>
                </div>
                <div class="p-3 bg-white rounded-xl border border-amber-100/80">
                    <i class="fa-solid fa-truck-fast text-batik-gold text-base mb-1 block"></i>
                    <span class="font-medium text-gray-800">Kirim Seluruh RI</span>
                </div>
                <div class="p-3 bg-white rounded-xl border border-amber-100/80">
                    <i class="fa-solid fa-rotate-left text-batik-gold text-base mb-1 block"></i>
                    <span class="font-medium text-gray-800">Bisa Tukar Ukuran</span>
                </div>
            </div>
        </div>

        <!-- Product Details & Form -->
        <div class="space-y-6">
            <!-- Header Info -->
            <div class="space-y-2 border-b border-gray-100 pb-5">
                <div class="flex items-center gap-3">
                    <span class="text-xs uppercase font-bold text-batik-gold bg-amber-50 px-3 py-1 rounded-full border border-amber-200">
                        {{ $product->category->name }}
                    </span>
                    <span class="text-xs text-gray-400">Kode SKU: <strong class="text-gray-700 font-mono">{{ $product->sku }}</strong></span>
                </div>

                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-gray-900 leading-snug">
                    {{ $product->name }}
                </h1>

                <!-- Price and Real-time Stock Summary -->
                <div class="flex items-baseline gap-4 pt-2">
                    <span class="text-3xl font-bold text-amber-900 font-serif">
                        {{ $product->formatted_price }}
                    </span>
                    <span class="text-xs text-gray-500 font-light">Harga resmi sudah termasuk PPN</span>
                </div>
            </div>

            <!-- Specifications Table -->
            <div class="bg-[#fdfbf7] p-4 rounded-2xl border border-amber-100 text-xs space-y-2">
                <div class="grid grid-cols-2 gap-2">
                    <div class="text-gray-500">Motif Filosofi:</div>
                    <div class="font-semibold text-gray-800">{{ $product->motif ?? 'Klasik Tradisional' }}</div>
                    
                    <div class="text-gray-500">Bahan Kain:</div>
                    <div class="font-semibold text-gray-800">{{ $product->material ?? 'Katun Primisima Halus' }}</div>

                    <div class="text-gray-500">Teknik Pembatikan:</div>
                    <div class="font-semibold text-gray-800">{{ $product->technique ?? 'Batik Cap Kombinasi Tulis' }}</div>

                    <div class="text-gray-500">Estimasi Berat:</div>
                    <div class="font-semibold text-gray-800">{{ $product->weight }} gram</div>
                </div>
            </div>

            <!-- Add to Cart Form -->
            <form method="POST" action="{{ route('cart.add') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="variant_id" :value="selectedVariantId">

                <!-- Variant / Size Selector -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Pilih Ukuran / Varian:
                        </label>
                        <span class="text-xs text-gray-500">
                            Stok Varian <strong x-text="selectedSize"></strong>:
                            <span :class="stockAvailable <= 0 ? 'text-rose-600 font-bold' : (stockAvailable <= 5 ? 'text-amber-600 font-bold' : 'text-emerald-600 font-bold')">
                                <span x-text="stockAvailable > 0 ? stockAvailable + ' pcs' : 'Habis'"></span>
                            </span>
                        </span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                        <template x-for="v in variants" :key="v.id">
                            <button type="button" @click="selectVariant(v)"
                                    :disabled="v.stock <= 0"
                                    :class="{
                                        'border-batik-gold bg-amber-50/80 text-batik-brown font-bold shadow-sm ring-2 ring-amber-500/20': selectedVariantId == v.id,
                                        'border-gray-200 bg-white text-gray-700 hover:border-amber-400': selectedVariantId != v.id && v.stock > 0,
                                        'border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed opacity-60 line-through': v.stock <= 0
                                    }"
                                    class="py-3 px-3 rounded-xl border text-xs text-center transition flex flex-col items-center justify-center">
                                <span class="font-semibold" x-text="v.size"></span>
                                <span class="text-[10px] mt-0.5" :class="v.stock <= 0 ? 'text-rose-500' : 'text-gray-500'" x-text="v.stock > 0 ? 'Sisa ' + v.stock : 'Habis'"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Quantity Selector -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Jumlah Pembelian:
                    </label>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center border border-gray-300 rounded-xl bg-white overflow-hidden shadow-sm">
                            <button type="button" @click="if(quantity > 1) quantity--"
                                    class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition">
                                <i class="fa-solid fa-minus text-xs"></i>
                            </button>
                            <input type="number" name="quantity" x-model.number="quantity" min="1" :max="stockAvailable"
                                   class="w-16 h-10 text-center font-bold text-sm border-x border-gray-200 outline-none" readonly>
                            <button type="button" @click="if(quantity < stockAvailable) quantity++"
                                    class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition"
                                    :disabled="quantity >= stockAvailable">
                                <i class="fa-solid fa-plus text-xs"></i>
                            </button>
                        </div>
                        <span class="text-xs text-gray-400">Maksimal <span x-text="stockAvailable"></span> pcs per pesanan</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <button type="submit" :disabled="stockAvailable <= 0"
                            class="flex-1 inline-flex items-center justify-center gap-2 bg-batik-brown text-batik-gold hover:bg-batik-dark font-bold py-3.5 px-6 rounded-full border border-batik-gold/40 shadow-md hover:shadow-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fa-solid fa-cart-plus text-sm"></i>
                        <span>+ Keranjang Belanja</span>
                    </button>

                    <button type="submit" name="buy_now" value="1" :disabled="stockAvailable <= 0"
                            class="flex-1 inline-flex items-center justify-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold py-3.5 px-6 rounded-full shadow-md hover:shadow-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fa-solid fa-bolt text-sm"></i>
                        <span>Beli Sekarang</span>
                    </button>
                </div>
            </form>

            <!-- Description Tabs -->
            <div class="border-t border-gray-100 pt-6 space-y-4" x-data="{ tab: 'desc' }">
                <div class="flex border-b border-gray-200 space-x-6 text-sm">
                    <button @click="tab = 'desc'" :class="tab === 'desc' ? 'border-b-2 border-batik-gold text-batik-brown font-bold' : 'text-gray-500 hover:text-gray-700'" class="pb-2">
                        Deskripsi Produk
                    </button>
                    <button @click="tab = 'care'" :class="tab === 'care' ? 'border-b-2 border-batik-gold text-batik-brown font-bold' : 'text-gray-500 hover:text-gray-700'" class="pb-2">
                        Petunjuk Perawatan
                    </button>
                    <button @click="tab = 'size'" :class="tab === 'size' ? 'border-b-2 border-batik-gold text-batik-brown font-bold' : 'text-gray-500 hover:text-gray-700'" class="pb-2">
                        Panduan Ukuran (Size Chart)
                    </button>
                </div>

                <!-- Tab 1: Description -->
                <div x-show="tab === 'desc'" class="text-sm text-gray-600 leading-relaxed font-light space-y-3">
                    <p>{{ $product->description }}</p>
                    <p class="text-xs text-amber-900 bg-amber-50 p-3 rounded-xl border border-amber-200 font-medium">
                        <i class="fa-solid fa-circle-info mr-1 text-batik-gold"></i>
                        Produk ini dibuat dengan tangan oleh perajin tradisional. Setiap helai memiliki keunikan goresan malam tersendiri sebagai ciri khas batik otentik.
                    </p>
                </div>

                <!-- Tab 2: Care -->
                <div x-show="tab === 'care'" x-cloak class="text-xs text-gray-600 leading-relaxed space-y-2">
                    <ul class="list-disc list-inside space-y-1.5">
                        <li>Cuci menggunakan sabun khusus lerak atau shampoo bayi lembut.</li>
                        <li>Hindari mencuci dengan mesin cuci dan jangan gunakan pemutih klorin.</li>
                        <li>Jangan memeras kain terlalu kuat untuk menjaga serat katun/sutra.</li>
                        <li>Jemur di tempat teduh yang berangin, hindari kontak sinar matahari langsung.</li>
                        <li>Setrika dengan suhu sedang (medium) dengan dilapisi kain tipis.</li>
                    </ul>
                </div>

                <!-- Tab 3: Size Chart -->
                <div x-show="tab === 'size'" x-cloak class="text-xs text-gray-600">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-amber-50 text-gray-800">
                                    <th class="p-2 border border-gray-200">Ukuran</th>
                                    <th class="p-2 border border-gray-200">Lingkar Dada (LD)</th>
                                    <th class="p-2 border border-gray-200">Panjang Baju</th>
                                    <th class="p-2 border border-gray-200">Panjang Lengan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-2 border border-gray-200 font-semibold">S</td>
                                    <td class="p-2 border border-gray-200">100 cm</td>
                                    <td class="p-2 border border-gray-200">70 cm</td>
                                    <td class="p-2 border border-gray-200">59 cm</td>
                                </tr>
                                <tr>
                                    <td class="p-2 border border-gray-200 font-semibold">M</td>
                                    <td class="p-2 border border-gray-200">106 cm</td>
                                    <td class="p-2 border border-gray-200">72 cm</td>
                                    <td class="p-2 border border-gray-200">60 cm</td>
                                </tr>
                                <tr>
                                    <td class="p-2 border border-gray-200 font-semibold">L</td>
                                    <td class="p-2 border border-gray-200">112 cm</td>
                                    <td class="p-2 border border-gray-200">74 cm</td>
                                    <td class="p-2 border border-gray-200">61 cm</td>
                                </tr>
                                <tr>
                                    <td class="p-2 border border-gray-200 font-semibold">XL</td>
                                    <td class="p-2 border border-gray-200">118 cm</td>
                                    <td class="p-2 border border-gray-200">76 cm</td>
                                    <td class="p-2 border border-gray-200">62 cm</td>
                                </tr>
                                <tr>
                                    <td class="p-2 border border-gray-200 font-semibold">XXL</td>
                                    <td class="p-2 border border-gray-200">124 cm</td>
                                    <td class="p-2 border border-gray-200">78 cm</td>
                                    <td class="p-2 border border-gray-200">63 cm</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-20 pt-12 border-t border-amber-100">
            <h2 class="font-serif text-2xl font-bold text-gray-900 mb-8">Koleksi Serupa Yang Mungkin Anda Sukai</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                        <a href="{{ route('shop.show', $rel->slug) }}" class="aspect-[3/4] block overflow-hidden bg-gray-50">
                            <img src="{{ $rel->image ?: 'https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?q=80&w=600&auto=format&fit=crop' }}"
                                 alt="{{ $rel->name }}" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        </a>
                        <div class="p-4">
                            <h4 class="font-medium text-gray-900 text-sm line-clamp-1 hover:text-batik-gold">
                                <a href="{{ route('shop.show', $rel->slug) }}">{{ $rel->name }}</a>
                            </h4>
                            <p class="text-xs text-amber-900 font-bold mt-1">{{ $rel->formatted_price }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
