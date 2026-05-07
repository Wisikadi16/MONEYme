<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Saldo (Seluruh Waktu)
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        $saldo = $totalIncome - $totalExpense;

        // Pemasukan dan Pengeluaran Bulan Ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $incomeBulanIni = Transaction::where('type', 'income')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $expenseBulanIni = Transaction::where('type', 'expense')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        // Insight Sederhana
        $pesanInsight = '';
        if ($expenseBulanIni > $incomeBulanIni) {
            $pesanInsight = '⚠️ Pengeluaran bulan ini lebih besar dari pemasukan. Kurangi pengeluaranmu!';
        } elseif ($incomeBulanIni > 0) {
            $pesanInsight = '✅ Kondisi keuangan bulan ini aman. Jangan lupa menabung!';
        } else {
            $pesanInsight = 'Mulai catat pemasukan dan pengeluaranmu!';
        }

        // 5 Transaksi Terbaru
        $recentTransactions = Transaction::with('category')
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'saldo', 
            'incomeBulanIni', 
            'expenseBulanIni', 
            'pesanInsight', 
            'recentTransactions'
        ));
    }
}
