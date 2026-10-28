@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white tracking-wide">DASHBOARD UTAMA</h2>
        <p class="text-sm text-gray-400">Selamat datang di Dior Store — Pusat manajemen inventaris dan butik eksklusif.</p>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Total Produk</p>
            <p class="text-3xl font-bold text-white">{{ $totalProducts ?? 0 }}</p>
        </div>
        <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Total Kategori</p>
            <p class="text-3xl font-bold text-white">{{ $totalCategories ?? 0 }}</p>
        </div>
        <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Total Pemasok</p>
            <p class="text-3xl font-bold text-white">{{ $totalSuppliers ?? 0 }}</p>
        </div>
        <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Total Pendapatan</p>
            <p class="text-3xl font-bold text-emerald-400">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- LOW STOCK TABLE -->
    <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
        <h3 class="text-lg font-semibold text-white mb-4">Peringatan Stok Menipis (&le; 5)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-800 text-xs text-gray-400 uppercase">
                        <th class="p-4">Kode Produk</th>
                        <th class="p-4">Nama Tas</th>
                        <th class="p-4">Sisa Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50 text-sm">
                    @forelse($lowStockProducts ?? [] as $product)
                        <tr>
                            <td class="p-4 font-medium text-white">{{ $product->product_code }}</td>
                            <td class="p-4 text-gray-300">{{ $product->name }}</td>
                            <td class="p-4 text-rose-400 font-medium">{{ $product->stock }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-6 text-center text-gray-500">Semua stok produk masih aman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection