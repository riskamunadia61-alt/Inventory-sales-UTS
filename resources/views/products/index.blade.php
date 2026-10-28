@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-wide">KATALOG PRODUK</h2>
            <p class="text-sm text-gray-400">Daftar inventaris tas mewah Dior.</p>
        </div>
        <a href="{{ route('products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition shadow-lg">+ Tambah Produk</a>
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
                        <th class="p-4">Kode</th>
                        <th class="p-4">Nama Tas</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Harga Jual</th>
                        <th class="p-4">Stok</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50 text-sm">
                    @forelse($products as $product)
                        <tr>
                            <td class="p-4 font-medium text-white">{{ $product->product_code }}</td>
                            <td class="p-4 text-gray-300">{{ $product->name }}</td>
                            <td class="p-4 text-gray-300">{{ $product->category->name ?? '-' }}</td>
                            <td class="p-4 text-emerald-400 font-medium">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                            <td class="p-4 text-gray-300">{{ $product->stock }}</td>
                            <td class="p-4 flex items-center gap-3">
                                <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-400 hover:underline font-medium">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-400 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">Belum ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection