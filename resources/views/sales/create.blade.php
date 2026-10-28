<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Penjualan - Dior Boutique</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#060913] text-gray-100 font-sans antialiased min-h-screen flex">
    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#0a0f1d] border-r border-gray-800 flex flex-col justify-between p-6">
        <div>
            <div class="mb-8">
                <h1 class="text-xl font-bold tracking-widest text-white">DIOR</h1>
                <p class="text-xs text-gray-400 tracking-wider">BOUTIQUE MANAGEMENT</p>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">📂 Dashboard</a>
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">📦 Katalog Produk</a>
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">🏷️ Kelola Kategori</a>
                <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">👥 Kelola Pemasok</a>
                <a href="{{ route('purchases.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">📥 Riwayat Restok</a>
                <a href="{{ route('sales.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-white font-medium transition">🛒 Kasir Penjualan</a>
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">📊 Laporan</a>
            </nav>
        </div>
        <div class="text-xs text-gray-500 text-center">&copy; 2026 DIOR STORE</div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-10 overflow-y-auto">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-white tracking-wide">KASIR PENJUALAN</h2>
            <p class="text-sm text-gray-400">Catat transaksi penjualan produk tas ke pelanggan.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-950/50 border border-rose-800 text-rose-300 rounded-xl text-sm">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg max-w-2xl">
            <form action="{{ route('sales.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs uppercase text-gray-400 mb-2">No. Faktur / Invoice</label>
                        <input type="text" name="invoice_number" value="INV-SL-{{ rand(100,999) }}" readonly class="w-full bg-[#060913] border border-gray-800 rounded-xl px-4 py-3 text-gray-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs uppercase text-gray-400 mb-2">Nama Pelanggan</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="Contoh: Siska" class="w-full bg-[#060913] border border-gray-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-600">
                    </div>
                </div>
                <div>
                    <label class="block text-xs uppercase text-gray-400 mb-2">Pilih Produk Tas</label>
                    <select name="product_id" required class="w-full bg-[#060913] border border-gray-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-600">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products ?? [] as $prod)
                            <option value="{{ $prod->id }}">{{ $prod->name }} — Rp {{ number_format($prod->selling_price, 0, ',', '.') }} (Stok: {{ $prod->stock }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs uppercase text-gray-400 mb-2">Jumlah Beli (Quantity)</label>
                    <input type="number" name="quantity" min="1" value="{{ old('quantity') }}" required placeholder="Contoh: 1" class="w-full bg-[#060913] border border-gray-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-600">
                </div>
                <div class="flex gap-3 pt-4">
                    <a href="{{ route('sales.index') }}" class="flex-1 text-center py-3 rounded-xl border border-gray-800 text-gray-400 hover:text-white transition text-sm">Batal</a>
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-medium text-sm transition shadow-lg">Proses Penjualan & Kurangi Stok</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>