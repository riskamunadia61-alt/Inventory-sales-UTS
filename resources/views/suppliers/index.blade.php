
@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-wide">KELOLA PEMASOK</h2>
            <p class="text-sm text-gray-400">Daftar pemasok dan supplier produk.</p>
        </div>
        <a href="{{ route('suppliers.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition shadow-lg">
            + Tambah Pemasok
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-950/50 border border-emerald-800 text-emerald-300 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-rose-950/50 border border-rose-800 text-rose-300 rounded-xl text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-[#0a0f1d] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-800 text-xs text-gray-400 uppercase">
                        <th class="p-4">Nama Pemasok</th>
                        <th class="p-4">Kontak / Telepon</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Alamat</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800/50 text-sm">
                    @forelse($suppliers as $supplier)
                        <tr>
                            <td class="p-4 font-medium text-white">
                                {{ $supplier->name }}
                            </td>

                            <td class="p-4 text-gray-300">
                                {{ $supplier->phone ?? '-' }}
                            </td>

                            <td class="p-4 text-gray-300">
                                {{ $supplier->email ?? '-' }}
                            </td>

                            <td class="p-4 text-gray-300">
                                {{ $supplier->address ?? '-' }}
                            </td>

                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                       class="text-indigo-400 hover:underline font-medium">
                                        Edit
                                    </a>

                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus pemasok ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-rose-400 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">
                                Belum ada data pemasok.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $suppliers->links() }}
        </div>
    </div>
@endsection
