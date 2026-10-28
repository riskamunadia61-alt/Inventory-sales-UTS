@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-wide">RIWAYAT KASIR PENJUALAN</h2>
            <p class="text-sm text-gray-400">Daftar transaksi penjualan tas kepada pelanggan.</p>
        </div>
        <a href="{{ route('sales.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition shadow-lg">+ Transaksi Baru</a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-950/50 border border-emerald-800 text-emerald-300 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-800 text-xs text-gray-400 uppercase">
                        <th class="p-4">No. Faktur</th>
                        <th class="p-4">Pelanggan</th>
                        <th class="p-4">Produk & Jumlah</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Total Harga</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50 text-sm">
                    @forelse($sales as $sale)
                        <tr>
                            <td class="p-4 font-medium text-white">{{ $sale->invoice_number }}</td>
                            <td class="p-4 text-gray-300">{{ $sale->customer_name }}</td>
                            <td class="p-4 text-gray-300">{{ $sale->product->name ?? 'Produk Dihapus' }} ({{ $sale->quantity }})</td>
                            <td class="p-4 text-gray-400">{{ $sale->sale_date ?? $sale->created_at->format('Y-m-d') }}</td>
                            <td class="p-4 text-emerald-400 font-medium">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                            <td class="p-4 flex items-center gap-3">
                                <a href="{{ route('sales.show', $sale->id) }}" class="text-indigo-400 hover:underline font-medium">Struk</a>
                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini? Stok produk akan dikembalikan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-400 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">Belum ada data transaksi penjualan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection