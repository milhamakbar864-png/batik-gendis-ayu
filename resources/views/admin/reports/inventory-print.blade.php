<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Nilai Persediaan Produk Batik - Batik Gendis Ayu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { padding: 0 !important; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 text-gray-800 antialiased" onload="window.print()">

    <div class="max-w-4xl mx-auto mb-4 flex justify-between items-center no-print">
        <button onclick="window.history.back()" class="text-xs text-amber-800 hover:underline font-semibold">
            &larr; Kembali
        </button>
        <button onclick="window.print()" class="bg-amber-800 hover:bg-amber-900 text-white font-bold text-xs py-2 px-5 rounded-lg shadow-sm">
            Cetak Ulang (PDF)
        </button>
    </div>

    <div class="max-w-4xl mx-auto bg-white p-10 rounded-2xl shadow-md border border-gray-200">
        <!-- Header -->
        <div class="border-b-2 border-amber-900 pb-4 text-center">
            <h1 class="text-2xl font-bold uppercase tracking-wider text-amber-950">Batik Gendis Ayu Yogyakarta</h1>
            <p class="text-xs text-gray-600">Jl. Malioboro No. 45, Gedongtengen, Kota Yogyakarta | Telp/WA: 0812-3456-7890</p>
            <h2 class="text-base font-bold uppercase tracking-wide text-gray-900 mt-3">Laporan Nilai Persediaan & Valuasi Stok Fisik</h2>
            <p class="text-xs text-gray-500">Per Tanggal: {{ date('d F Y') }}</p>
        </div>

        <!-- Inventory Summary -->
        <div class="grid grid-cols-4 gap-4 py-6 border-b border-gray-200 text-xs text-center">
            <div class="p-3 bg-gray-50 rounded-lg">
                <span class="text-gray-500 block">Total Fisik Persediaan</span>
                <strong class="text-sm text-gray-900 block mt-0.5">{{ number_format($totalStockUnits) }} pcs</strong>
            </div>
            <div class="p-3 bg-gray-50 rounded-lg">
                <span class="text-gray-500 block">Total Nilai Aset (HPP)</span>
                <strong class="text-sm text-amber-900 block mt-0.5">Rp {{ number_format($totalAssetValue, 0, ',', '.') }}</strong>
            </div>
            <div class="p-3 bg-gray-50 rounded-lg">
                <span class="text-gray-500 block">Nilai Jual Retail</span>
                <strong class="text-sm text-blue-900 block mt-0.5">Rp {{ number_format($totalRetailValue, 0, ',', '.') }}</strong>
            </div>
            <div class="p-3 bg-emerald-50 rounded-lg border border-emerald-200">
                <span class="text-emerald-800 font-bold block">Potensi Margin Laba</span>
                <strong class="text-sm text-emerald-700 block mt-0.5">Rp {{ number_format($potentialMargin, 0, ',', '.') }}</strong>
            </div>
        </div>

        <!-- Inventory Table -->
        <div class="py-6">
            <table class="w-full text-xs text-left border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase">
                        <th class="p-2 border border-gray-200">No</th>
                        <th class="p-2 border border-gray-200">SKU</th>
                        <th class="p-2 border border-gray-200">Nama Produk</th>
                        <th class="p-2 border border-gray-200">Kategori</th>
                        <th class="p-2 border border-gray-200 text-center">Stok</th>
                        <th class="p-2 border border-gray-200 text-right">HPP</th>
                        <th class="p-2 border border-gray-200 text-right">Harga Jual</th>
                        <th class="p-2 border border-gray-200 text-right">Nilai Aset</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $idx => $p)
                        @php
                            $st = $p->total_stock;
                            $val = $st * $p->buy_price;
                        @endphp
                        <tr>
                            <td class="p-2 border border-gray-200 text-center">{{ $idx + 1 }}</td>
                            <td class="p-2 border border-gray-200 font-mono">{{ $p->sku }}</td>
                            <td class="p-2 border border-gray-200">{{ $p->name }}</td>
                            <td class="p-2 border border-gray-200">{{ $p->category->name }}</td>
                            <td class="p-2 border border-gray-200 text-center font-bold">{{ $st }}</td>
                            <td class="p-2 border border-gray-200 text-right">{{ $p->formatted_buy_price }}</td>
                            <td class="p-2 border border-gray-200 text-right">{{ $p->formatted_price }}</td>
                            <td class="p-2 border border-gray-200 text-right font-bold">Rp {{ number_format($val, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50 font-bold">
                        <td colspan="4" class="p-2 border border-gray-200 text-right">TOTAL:</td>
                        <td class="p-2 border border-gray-200 text-center">{{ number_format($totalStockUnits) }} pcs</td>
                        <td colspan="2" class="p-2 border border-gray-200 text-right">TOTAL ASET:</td>
                        <td class="p-2 border border-gray-200 text-right text-amber-900">Rp {{ number_format($totalAssetValue, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Signature Block -->
        <div class="mt-10 pt-6 flex justify-between items-end text-xs text-gray-600">
            <div>
                <p>Bagian Gudang & Persediaan,</p>
                <p class="mt-14 font-bold text-gray-900">Petugas Inventory Control</p>
            </div>
            <div class="text-right">
                <p>Yogyakarta, {{ date('d F Y') }}</p>
                <p class="mt-14 font-bold text-gray-900">Pimpinan Galeri Batik Gendis Ayu</p>
            </div>
        </div>
    </div>
</body>
</html>
