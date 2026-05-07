@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center">
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-indigo-600 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">
            @if($type === 'income')
                Catat Pemasukan Baru 💰
            @elseif($type === 'expense')
                Catat Pengeluaran Baru 💸
            @else
                Catat Transaksi Baru
            @endif
        </h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                
                <!-- Category Selection -->
                <div class="mb-5">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <div class="relative">
                        <select id="category_id" name="category_id" required class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 bg-gray-50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg border appearance-none">
                            <option value="" disabled selected>Pilih kategori transaksi...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }} ({{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Amount Input -->
                <div class="mb-5">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Uang</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-medium">Rp</span>
                        </div>
                        <input type="number" name="amount" id="amount" required min="1" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 pr-4 py-3 sm:text-lg border-gray-300 bg-gray-50 border rounded-lg" placeholder="0">
                    </div>
                </div>

                <!-- Date Input -->
                <div class="mb-5">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="date" id="date" required value="{{ date('Y-m-d') }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 sm:text-sm border-gray-300 bg-gray-50 border rounded-lg">
                </div>

                <!-- Description Input -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                    <textarea id="description" name="description" rows="3" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 sm:text-sm border-gray-300 bg-gray-50 border rounded-lg" placeholder="Misal: Makan siang ayam penyet"></textarea>
                </div>

                <!-- Submit Button -->
                <div>
                    @php
                        $btnColor = 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500';
                        if($type === 'income') $btnColor = 'bg-green-600 hover:bg-green-700 focus:ring-green-500';
                        if($type === 'expense') $btnColor = 'bg-red-600 hover:bg-red-700 focus:ring-red-500';
                    @endphp
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white {{ $btnColor }} focus:outline-none focus:ring-2 focus:ring-offset-2 transition">
                        Simpan Transaksi
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
