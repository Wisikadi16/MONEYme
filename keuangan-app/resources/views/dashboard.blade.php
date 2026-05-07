@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Insight Section -->
    @if($pesanInsight)
    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 {{ $expenseBulanIni > $incomeBulanIni ? 'border-red-500 text-red-700 bg-red-50' : 'border-green-500 text-green-700 bg-green-50' }}">
        <p class="font-medium">{{ $pesanInsight }}</p>
    </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Saldo Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex flex-col justify-center">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-2">Saldo Sekarang</h3>
            <p class="text-4xl font-bold text-gray-800">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
        </div>

        <!-- Income Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex flex-col justify-center relative overflow-hidden">
            <div class="absolute right-0 top-0 mt-6 mr-6 opacity-10">
                <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-2">Pemasukan Bulan Ini</h3>
            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($incomeBulanIni, 0, ',', '.') }}</p>
        </div>

        <!-- Expense Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex flex-col justify-center relative overflow-hidden">
            <div class="absolute right-0 top-0 mt-6 mr-6 opacity-10">
                <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
            </div>
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-2">Pengeluaran Bulan Ini</h3>
            <p class="text-3xl font-bold text-red-600">Rp {{ number_format($expenseBulanIni, 0, ',', '.') }}</p>
        </div>

    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Transactions List -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Transaksi Terbaru</h2>
                <a href="{{ route('transactions.create') }}" class="text-sm text-indigo-600 font-medium hover:text-indigo-800">Catat Transaksi Baru &rarr;</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-3 font-medium">Tanggal</th>
                            <th class="px-6 py-3 font-medium">Kategori</th>
                            <th class="px-6 py-3 font-medium">Catatan</th>
                            <th class="px-6 py-3 font-medium text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentTransactions as $tx)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($tx->date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $tx->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $tx->description ?: '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-right {{ $tx->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $tx->type === 'income' ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data transaksi. Ayo mulai mencatat!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Column: Quick Actions & Chart Placeholder -->
        <div class="space-y-6">
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('transactions.create', ['type' => 'income']) }}" class="flex flex-col items-center justify-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition border border-green-100">
                        <span class="text-xl mb-1">💰</span>
                        <span class="text-sm font-medium text-green-700 text-center">Catat<br>Pemasukan</span>
                    </a>
                    <a href="{{ route('transactions.create', ['type' => 'expense']) }}" class="flex flex-col items-center justify-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition border border-red-100">
                        <span class="text-xl mb-1">💸</span>
                        <span class="text-sm font-medium text-red-700 text-center">Catat<br>Pengeluaran</span>
                    </a>
                    <a href="#" class="col-span-2 flex items-center justify-center p-3 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition border border-indigo-100 mt-1">
                        <span class="text-xl mr-2">🎯</span>
                        <span class="text-sm font-medium text-indigo-700">Target Tabungan (Segera)</span>
                    </a>
                </div>
            </div>

            <!-- Chart Placeholder -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Grafik Pengeluaran</h2>
                <div class="h-48 flex items-center justify-center bg-gray-50 rounded-lg border border-dashed border-gray-200">
                    <p class="text-sm text-gray-400 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Grafik akan muncul setelah ada data
                    </p>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
