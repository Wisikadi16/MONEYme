@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Kustomisasi Aksi Cepat</h1>
        <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800">&larr; Kembali ke Dashboard</a>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-lg border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Form Tambah Template Baru -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Buat Template Baru</h2>
            <form action="{{ route('templates.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Template</label>
                        <input type="text" name="name" placeholder="Cth: Kopi Hitam" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }} ({{ $cat->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="type" value="expense"> <!-- Tipe di-handle di controller mengikuti kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp)</label>
                        <input type="number" name="amount" placeholder="15000" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ikon (Emoji Opsional)</label>
                        <input type="text" name="icon" placeholder="☕" maxlength="5" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white font-medium py-2 px-4 rounded-md hover:bg-indigo-700 transition">
                        Simpan Template
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Template Anda -->
        <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Daftar Template Anda</h2>
            @if($templates->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-3">Ikon & Nama</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Nominal</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($templates as $template)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-800">
                                        <span class="mr-2">{{ $template->icon }}</span> {{ $template->name }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $template->category->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-800">Rp {{ number_format($template->amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <form action="{{ route('templates.destroy', $template->id) }}" method="POST" onsubmit="return confirm('Hapus template ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    Anda belum memiliki template kustom. Silakan buat di form sebelah kiri.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
