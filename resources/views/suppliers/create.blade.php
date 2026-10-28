@extends('layouts.app')

@section('content')
    <div class="max-w-xl">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-white tracking-wide">TAMBAH PEMASOK</h2>
            <p class="text-sm text-gray-400">Masukkan informasi pemasok baru.</p>
        </div>

        <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
            <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-2">Nama Pemasok</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-white/5 border border-gray-800 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-2">Kontak / Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full bg-white/5 border border-gray-800 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                
        <div class="mb-4">
                    <label class="block text-xs uppercase text-gray-400 mb-2">
            Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email pemasok"
                        class="w-full bg-[#060913] border border-gray-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500"
            >
        </div>

                    <label class="block text-xs font-medium text-gray-400 uppercase mb-2">Alamat</label>
                    <textarea name="address" rows="3" class="w-full bg-white/5 border border-gray-800 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">{{ old('address') }}</textarea>
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('suppliers.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-800 text-gray-300 hover:bg-gray-700 transition text-sm font-medium">Batal</a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 transition text-sm font-medium shadow-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection