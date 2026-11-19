<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan ({{ $startDate }} s.d. {{ $endDate }}) - Batik Gendis Ayu</title>
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
            <h2 class="text-base font-bold uppercase tracking-wide text-gray-900 mt-3">Laporan Rekapitulasi Penjualan & Laba Rugi</h2>
            <p class="text-xs text-gray-500">Periode: {{ date('d F Y', strtotime($startDate)) }} s.d. {{ date('d F Y', strtotime($endDate)) }}</p>
        </div>

        <!-- Financial Summary -->
        <div class="grid grid-cols-4 gap-4 py-6 border-b border-gray-200 text-xs text-center">
            <div class="p-3 bg-gray-50 rounded-lg">
                <span class="text-gray-500 block">Total Omzet Bruto</span>
                <strong class="text-sm text-gray-900 block mt-0.5">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong>
            </div>
            <div class="p-3 bg-gray-50 rounded-lg">
                <span class="text-gray-500 block">Penjualan Produk</span>
                <strong class="text-sm text-gray-900 block mt-0.5">Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</strong>
            </div>
            <div class="p-3 bg-gray-50 rounded-lg">
                <span class="text-gray-500 block">Total HPP / Modal</span>
                <strong class="text-sm text-rose-700 block mt-0.5">Rp {{ number_format($totalHpp, 0, ',', '.') }}</strong>
            </div>
            <div class="p-3 bg-emerald-50 rounded-lg border border-emerald-200">
                <span class="text-emerald-800 font-bold block">Laba Bersih</span>
                <strong class="text-sm text-emerald-700 block mt-0.5">Rp {{ number_format($netProfit, 0, ',', '.') }}</strong>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="py-6">
            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-700 mb-3">Rincian Transaksi Penjualan</h3>
            <table class="w-full text-xs text-left border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase">
                        <th class="p-2 border border-gray-200">No</th>
                        <th class="p-2 border border-gray-200">Tanggal</th>
                        <th class="p-2 border border-gray-200">No. Order</th>
                        <th class="p-2 border border-gray-200">Pelanggan</th>
                        <th class="p-2 border border-gray-200">Kota</th>
                        <th class="p-2 border border-gray-200 text-right">Subtotal</th>
                        <th class="p-2 border border-gray-200 text-right">Ongkir</th>
                        <th class="p-2 border border-gray-200 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $idx => $o)
                        <tr>
                            <td class="p-2 border border-gray-200 text-center">{{ $idx + 1 }}</td>
                            <td class="p-2 border border-gray-200">{{ $o->created_at->format('d/m/Y') }}</td>
                            <td class="p-2 border border-gray-200 font-mono">{{ $o->order_number }}</td>
                            <td class="p-2 border border-gray-200">{{ $o->customer_name }}</td>
                            <td class="p-2 border border-gray-200">{{ $o->city }}</td>
                            <td class="p-2 border border-gray-200 text-right">{{ $o->formatted_subtotal }}</td>
                            <td class="p-2 border border-gray-200 text-right">{{ $o->formatted_shipping_cost }}</td>
                            <td class="p-2 border border-gray-200 text-right font-bold">{{ $o->formatted_total }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50 font-bold">
                        <td colspan="5" class="p-2 border border-gray-200 text-right">TOTAL KESELURUHAN:</td>
                        <td class="p-2 border border-gray-200 text-right">Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</td>
                        <td class="p-2 border border-gray-200 text-right">Rp {{ number_format($totalShipping, 0, ',', '.') }}</td>
                        <td class="p-2 border border-gray-200 text-right text-amber-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Signature Block -->
        <div class="mt-10 pt-6 flex justify-between items-end text-xs text-gray-600">
            <div>
                <p>Mengetahui,</p>
                <p class="mt-14 font-bold text-gray-900">Pimpinan / Pemilik Galeri</p>
            </div>
            <div class="text-right">
                <p>Yogyakarta, {{ date('d F Y') }}</p>
                <p class="mt-14 font-bold text-gray-900">Bagian Keuangan & Administrasi</p>
            </div>
        </div>
    </div>
</body>
</html>
