@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-wide">LAPORAN PENJUALAN</h2>
            <p class="text-sm text-gray-400">Rekapitulasi laporan transaksi dan pendapatan butik.</p>
        </div>
    </div>

    <!-- KOTAK STATISTIK -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Total Seluruh Transaksi</p>
            <h3 class="text-3xl font-bold text-white">{{ $totalTransactions }}</h3>
        </div>
        <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Total Pendapatan</p>
            <h3 class="text-3xl font-bold text-emerald-400">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
    </div>

    <!-- FORM PENCARIAN & FILTER TANGGAL -->
    <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 mb-6 shadow-lg">
        <form action="{{ route('reports.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs text-gray-400 uppercase mb-2">Cari Faktur / Pelanggan</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="No. Faktur atau Nama Pelanggan..." class="w-full bg-[#131b2e] border border-gray-800 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs text-gray-400 uppercase mb-2">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="bg-[#131b2e] border border-gray-800 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs text-gray-400 uppercase mb-2">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="bg-[#131b2e] border border-gray-800 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition">Filter</button>
                @if(request('search') || request('start_date') || request('end_date'))
                    <a href="{{ route('reports.index') }}" class="bg-gray-800 hover:bg-gray-700 text-gray-300 px-5 py-2.5 rounded-xl text-sm font-medium transition flex items-center">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- TABEL RINCIAN LAPORAN -->
    <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
        <h3 class="text-lg font-bold text-white mb-4">Rincian Laporan Penjualan</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-800 text-xs text-gray-400 uppercase">
                        <th class="p-4">No. Faktur</th>
                        <th class="p-4">Pelanggan</th>
                        <th class="p-4">Produk</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Total</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50 text-sm">
                    @forelse($sales as $sale)
                        <tr>
                            <td class="p-4 font-medium text-white">{{ $sale->sale_number ?? 'INV-SL-' . $sale->id }}</td>
                            <td class="p-4 text-gray-300">{{ $sale->customer_name ?? '-' }}</td>
                            <td class="p-4 text-gray-300">{{ $sale->product->name ?? 'Produk Dihapus' }}</td>
                            <td class="p-4 text-gray-400">{{ $sale->sold_at ?? $sale->created_at->format('Y-m-d') }}</td>
                            <td class="p-4 text-emerald-400 font-medium">Rp {{ number_format($sale->total ?? $sale->total_amount ?? 0, 0, ',', '.') }}</td>
                            <td class="p-4">
                                <a href="{{ route('sales.receipt', $sale->id) }}" target="_blank" class="bg-indigo-600/20 hover:bg-indigo-600 text-indigo-300 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">Cetak Struk</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">Tidak ada data laporan transaksi yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-6">
            {{ $sales->withQueryString()->links() }}
        </div>
    </div>
@endsection