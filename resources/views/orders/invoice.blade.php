<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->order_number }} - Batik Gendis Ayu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0 !important; }
        }
    </style>
</head>
<body class="bg-gray-100 p-4 sm:p-8 text-gray-800 antialiased">

    <!-- Action Bar for Screen -->
    <div class="max-w-3xl mx-auto mb-4 flex justify-between items-center no-print">
        <a href="{{ route('order.detail', $order->order_number) }}" class="text-xs text-amber-800 hover:underline font-semibold">
            &larr; Kembali ke Rincian Pesanan
        </a>
        <button onclick="window.print()" class="bg-amber-800 hover:bg-amber-900 text-white font-bold text-xs py-2 px-5 rounded-lg shadow-sm">
            Cetak Invoice (PDF)
        </button>
    </div>

    <!-- Invoice Sheet -->
    <div class="max-w-3xl mx-auto bg-white p-8 sm:p-12 rounded-2xl shadow-md border border-gray-200">
        <!-- Invoice Header -->
        <div class="flex justify-between items-start border-b-2 border-amber-800 pb-6">
            <div>
                <h1 class="font-serif text-2xl font-bold text-amber-900 tracking-wide">Batik Gendis Ayu</h1>
                <p class="text-xs text-gray-500 mt-1 max-w-xs leading-relaxed">
                    Galeri Batik Tulis & Cap Tradisional Nusantara<br>
                    Jl. Malioboro No. 45, Gedongtengen, Yogyakarta 55271<br>
                    WhatsApp: 0812-3456-7890 | Email: info@batikgendisayu.com
                </p>
            </div>
            <div class="text-right">
                <span class="text-xs uppercase font-bold text-gray-400 tracking-widest block">INVOICE PENJUALAN</span>
                <span class="font-mono text-base font-bold text-gray-900">{{ $order->order_number }}</span>
                <p class="text-xs text-gray-500 mt-1">Tanggal: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <div class="mt-2">
                    @if($order->payment_status === 'paid')
                        <span class="inline-block border-2 border-emerald-600 text-emerald-700 font-bold text-xs uppercase px-3 py-1 rounded tracking-wider rotate-[-5deg]">
                            LUNAS
                        </span>
                    @else
                        <span class="inline-block border-2 border-amber-600 text-amber-700 font-bold text-xs uppercase px-3 py-1 rounded tracking-wider rotate-[-5deg]">
                            BELUM LUNAS
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Customer & Order Meta -->
        <div class="grid grid-cols-2 gap-6 py-6 border-b border-gray-100 text-xs">
            <div>
                <span class="text-gray-400 uppercase tracking-wider block font-bold mb-1">Ditujukan Kepada:</span>
                <p class="font-bold text-sm text-gray-800">{{ $order->customer_name }}</p>
                <p class="text-gray-600 mt-0.5">{{ $order->customer_phone }}</p>
                <p class="text-gray-600 mt-0.5 leading-relaxed">{{ $order->shipping_address }}, {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}</p>
            </div>
            <div class="text-right">
                <span class="text-gray-400 uppercase tracking-wider block font-bold mb-1">Rincian Pengiriman:</span>
                <p class="text-gray-700">Jasa Kurir: <strong class="text-gray-900">{{ $order->courier }}</strong></p>
                @if($order->tracking_number)
                    <p class="text-gray-700 font-mono mt-0.5">Resi: <strong class="text-gray-900">{{ $order->tracking_number }}</strong></p>
                @endif
                <p class="text-gray-700 mt-0.5">Metode Bayar: <strong>{{ $order->payment_method }}</strong></p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="py-6">
            <table class="w-full text-xs text-left">
                <thead>
                    <tr class="border-b border-gray-200 text-gray-400 uppercase tracking-wider">
                        <th class="py-2">No</th>
                        <th class="py-2">Item Produk Batik</th>
                        <th class="py-2 text-center">Ukuran</th>
                        <th class="py-2 text-center">Qty</th>
                        <th class="py-2 text-right">Harga Satuan</th>
                        <th class="py-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @foreach($order->items as $idx => $item)
                        <tr>
                            <td class="py-3 text-gray-400">{{ $idx + 1 }}</td>
                            <td class="py-3 font-semibold text-gray-800">{{ $item->product_name }}</td>
                            <td class="py-3 text-center">{{ $item->variant_size }}</td>
                            <td class="py-3 text-center font-bold">{{ $item->quantity }}</td>
                            <td class="py-3 text-right">{{ $item->formatted_price }}</td>
                            <td class="py-3 text-right font-bold text-gray-900">{{ $item->formatted_subtotal }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Calculation Summary -->
        <div class="border-t-2 border-gray-200 pt-4 flex justify-between items-start text-xs">
            <div class="max-w-xs text-gray-500">
                <p class="font-bold text-gray-700 mb-1">Catatan Pesanan:</p>
                <p class="italic">{{ $order->customer_notes ?: 'Terima kasih telah mencintai warisan budaya adiluhung batik nusantara bersama Batik Gendis Ayu.' }}</p>
            </div>

            <div class="w-64 space-y-2">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal Barang:</span>
                    <span class="font-semibold">{{ $order->formatted_subtotal }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Ongkos Kirim:</span>
                    <span class="font-semibold">{{ $order->formatted_shipping_cost }}</span>
                </div>
                <div class="border-t border-gray-300 pt-2 flex justify-between text-sm font-bold text-amber-950">
                    <span>Total Pembayaran:</span>
                    <span>{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

        <!-- Signature Block -->
        <div class="mt-12 pt-6 border-t border-gray-100 flex justify-between items-end text-xs text-gray-500">
            <div>
                <p>Galeri Batik Gendis Ayu</p>
                <p class="mt-12 font-bold text-gray-800">Manajemen Toko</p>
            </div>
            <div class="text-right">
                <p>Yogyakarta, {{ $order->created_at->format('d F Y') }}</p>
                <p class="mt-12 font-bold text-gray-800">{{ $order->customer_name }}</p>
            </div>
        </div>
    </div>
</body>
</html>
