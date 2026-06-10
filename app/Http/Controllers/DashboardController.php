<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\BudgetSource;
use App\Models\Transaction; 

class DashboardController extends Controller
{
    /**
     * Menampilkan Integrasi Data Utama di Dashboard
     */
    public function index()
    {
        $userId = auth()->id();

        // 1. Ambil modal dasar / sumber dana
        $totalSource = BudgetSource::where('user_id', $userId)->sum('amount');

        // 2. Hitung akumulasi transaksi global (pemasukan & pengeluaran)
        $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');

        // 3. Eksekusi rumus finansial (sinkron dengan rumus BudgetController temanmu)
        $totalAssets = $totalSource + ($totalIncome - $totalExpense);
        $totalAllocated = Budget::where('user_id', $userId)->sum('allocated_amount');
        $unallocatedFunds = $totalAssets - $totalAllocated;
        $totalRemaining = $totalAllocated - $totalExpense;

        // 4. Ambil 4 riwayat transaksi paling baru milik user (menyesuaikan jumlah list di UI kamu)
        $recentTransactions = Transaction::where('user_id', $userId)
            ->latest()
            ->take(4)
            ->get();

        // 5. Kirim bungkusan variabel ke view dashboard
        return view('dashboard.dashboard', compact(
            'totalAssets',
            'totalIncome',
            'totalExpense',
            'totalRemaining',
            'unallocatedFunds',
            'recentTransactions'
        ));
    }
}