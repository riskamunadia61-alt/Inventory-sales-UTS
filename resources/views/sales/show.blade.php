<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian - Dior Boutique</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#060913] text-gray-100 font-sans antialiased min-h-screen flex items-center justify-center p-6">
    <div class="bg-[#0a0f1d] border border-gray-800 rounded-2xl p-8 shadow-xl w-full max-w-md">
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold tracking-widest text-white">DIOR BOUTIQUE</h1>
            <p class="text-xs text-gray-400">Jl. Butik Mewah No. 88, Jakarta</p>
            <p class="text-xs text-gray-500 mt-1">Struk Pembelian / Nota Penjualan</p>
        </div>

        <div class="border-t border-b border-gray-800 py-4 mb-4 text-sm space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-400">No. Faktur:</span>
                <span class="text-white font-medium">{{ $sale->invoice_number }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-400">Tanggal:</span>
                <span class="text-white">{{ $sale->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-400">Pelanggan:</span>
                <span class="text-white">{{ $sale->customer_name }}</span>
            </div>
        </div>

        <div class="mb-6 space-y-2 text-sm">
            <div class="flex justify-between text-gray-400 font-medium pb-2 border-b border-gray-800/50">
                <span>Item Produk</span>
                <span>Subtotal</span>
            </div>
            <div class="flex justify-between">
                <div>
                    <p class="text-white">{{ $sale->product->name ?? 'Produk' }}</p>
                    <p class="text-xs text-gray-400">{{ $sale->quantity }}x @ Rp {{ number_format($sale->product->selling_price ?? 0, 0, ',', '.') }}</p>
                </div>
                <span class="text-white">Rp {{ number_format(($sale->quantity * ($sale->product->selling_price ?? 0)), 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-4 mb-6 flex justify-between items-center text-base font-bold">
            <span class="text-white">TOTAL BAYAR:</span>
            <span class="text-indigo-400">Rp {{ number_format(($sale->quantity * ($sale->product->selling_price ?? 0)), 0, ',', '.') }}</span>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('sales.index') }}" class="flex-1 text-center py-2.5 rounded-xl border border-gray-800 text-gray-400 hover:text-white text-sm transition">Kembali</a>
            <button onclick="window.print()" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-xl font-medium text-sm transition shadow-lg">Cetak Struk</button>
        </div>
    </div>
</body>
</html>