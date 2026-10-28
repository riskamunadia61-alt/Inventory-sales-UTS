@extends('layouts.app')

@section('content')
    <div class="max-w-xl">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-white tracking-wide">TAMBAH RESTOK PRODUK</h2>
            <p class="text-sm text-gray-400">Catat penambahan stok barang dari pemasok.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-950/50 border border-rose-800 text-rose-300 rounded-xl text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
            <form action="{{ route('purchases.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-2">Nomor Restok / Faktur</label>
                    <input type="text" name="purchase_number" value="{{ old('purchase_number') }}" required class="w-full bg-white/5 border border-gray-800 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-2">Pemasok</label>
                    <select name="supplier_id" required class="w-full bg-[#0a0f1d] border border-gray-800 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                        <option value="" class="bg-[#0a0f1d] text-gray-400">Pilih Pemasok</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" class="bg-[#0a0f1d] text-white" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-2">Produk</label>
                    <select name="product_id" required class="w-full bg-[#0a0f1d] border border-gray-800 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                        <option value="" class="bg-[#0a0f1d] text-gray-400">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" class="bg-[#0a0f1d] text-white" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (Stok: {{ $product->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-2">Harga Beli</label>
                    <input type="number" name="purchase_price" value="{{ old('purchase_price') }}" required class="w-full bg-white/5 border border-gray-800 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-2">Jumlah Restok (Kuantitas)</label>
                    <input type="number" name="quantity" min="1" value="{{ old('quantity') }}" required class="w-full bg-white/5 border border-gray-800 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('purchases.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-800 text-gray-300 hover:bg-gray-700 transition text-sm font-medium">Batal</a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 transition text-sm font-medium shadow-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection