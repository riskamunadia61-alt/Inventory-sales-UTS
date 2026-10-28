<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dior Boutique Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#060913] text-gray-100 font-sans antialiased min-h-screen flex">
    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#0a0f1d] border-r border-gray-800 flex flex-col justify-between p-6">
        <div>
            <div class="mb-6">
                <h1 class="text-xl font-bold tracking-widest text-white">DIOR</h1>
                <p class="text-xs text-gray-400 tracking-wider">BOUTIQUE MANAGEMENT</p>
            </div>

            <!-- KOTAK INFORMASI USER / LOGIN -->
            @auth
                <div class="mb-6 p-3 bg-white/5 border border-white/10 rounded-xl text-xs">
                    <p class="text-gray-400">Selamat datang,</p>
                    <p class="font-semibold text-white">{{ Auth::user()->name }} <span class="text-indigo-400 capitalize">({{ Auth::user()->role }})</span></p>
                </div>
            @endauth

            <!-- MENU NAVIGASI -->
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white font-medium shadow-lg' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} transition">
                    📂 Dashboard
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('products*') ? 'bg-indigo-600 text-white font-medium shadow-lg' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} transition">
                    📦 Katalog Produk
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('categories*') ? 'bg-indigo-600 text-white font-medium shadow-lg' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} transition">
                    🏷️ Kelola Kategori
                </a>
                <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('suppliers*') ? 'bg-indigo-600 text-white font-medium shadow-lg' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} transition">
                    👥 Kelola Pemasok
                </a>
                <a href="{{ route('purchases.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('purchases*') ? 'bg-indigo-600 text-white font-medium shadow-lg' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} transition">
                    📥 Riwayat Restok
                </a>
                <a href="{{ route('sales.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('sales*') ? 'bg-indigo-600 text-white font-medium shadow-lg' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} transition">
                    🛒 Kasir Penjualan
                </a>
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('reports*') ? 'bg-indigo-600 text-white font-medium shadow-lg' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} transition">
                    📊 Laporan
                </a>
            </nav>
        </div>

        <!-- TOMBOL KELUAR (LOGOUT) & FOOTER -->
        <div class="space-y-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-rose-400 hover:bg-rose-500/10 transition font-medium text-sm">
                    🚪 Keluar (Logout)
                </button>
            </form>
            <div class="text-xs text-gray-500 text-center">&copy; 2026 DIOR STORE</div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-10 overflow-y-auto">
        @yield('content')
    </main>
</body>
</html>