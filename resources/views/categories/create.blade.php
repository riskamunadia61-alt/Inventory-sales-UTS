@extends('layouts.app')

@section('content')
    <div class="max-w-xl">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-white tracking-wide">TAMBAH KATEGORI</h2>
            <p class="text-sm text-gray-400">Masukkan nama kategori baru.</p>
        </div>

        <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
            <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-2">Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-white/5 border border-gray-800 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('categories.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-800 text-gray-300 hover:bg-gray-700 transition text-sm font-medium">Batal</a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 transition text-sm font-medium shadow-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection