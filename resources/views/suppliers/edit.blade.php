<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemasok - Dior Boutique</title>
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
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                    📂 Dashboard
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                    📦 Katalog Produk
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                    🏷️ Kelola Kategori
                </a>
                <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-white font-medium transition">
                    👥 Kelola Pemasok
                </a>
                <a href="{{ route('purchases.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                    📥 Riwayat Restok
                </a>
                <a href="{{ route('sales.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                    🛒 Kasir Penjualan
                </a>
            </nav>
        </div>
        <div class="text-xs text-gray-500 text-center">&copy; 2026 DIOR STORE</div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-10 overflow-y-auto">
        <div class="max-w-xl">
            <h2 class="text-2xl font-bold text-white tracking-wide mb-2">EDIT PEMASOK</h2>
            <p class="text-sm text-gray-400 mb-6">Perbarui informasi mitra pemasok.</p>

            <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
                <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-xs uppercase text-gray-400 mb-2">Nama Pemasok</label>
                        <input type="text" name="name" value="{{ old('name', $supplier->name) }}" required class="w-full bg-[#060913] border border-gray-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs uppercase text-gray-400 mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}" class="w-full bg-[#060913] border border-gray-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs uppercase text-gray-400 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $supplier->email) }}" class="w-full bg-[#060913] border border-gray-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500">
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs uppercase text-gray-400 mb-2">Alamat</label>
                        <textarea name="address" rows="3" class="w-full bg-[#060913] border border-gray-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500">{{ old('address', $supplier->address) }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('suppliers.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-800 text-gray-400 hover:text-white text-sm transition">Batal</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition shadow-lg">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>