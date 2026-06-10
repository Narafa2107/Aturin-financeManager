<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Controllers\StatisticsController;
use App\Models\Budget;
use App\Models\BudgetSource;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan Integrasi Data Utama di Dashboard
     */
    public function index()
    {
        $userId = auth()->id();

        // 1. Ambil modal dasar 
        $totalSource = BudgetSource::where('user_id', $userId)->sum('amount');

        // 2. Hitung akumulasi transaksi (pemasukan & pengeluaran)
        $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');

        // Eksekusi rumus finansial (sinkron dengan rumus BudgetController)
        $totalAssets = $totalSource + ($totalIncome - $totalExpense);
        $totalAllocated = Budget::where('user_id', $userId)->sum('allocated_amount');
        $unallocatedFunds = $totalAssets - $totalAllocated;
        $totalRemaining = $totalAllocated - $totalExpense;

        // Ambil 4 riwayat transaksi paling baru berdasarkan transaction_date
        $recentTransactions = Transaction::where('user_id', $userId)
            ->orderBy('transaction_date', 'desc')
            ->take(4)
            ->get();

        // MONTHLY STATISTICS
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        // Income comparison
        $currentIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('transaction_date', $currentMonth->year)
            ->whereMonth('transaction_date', $currentMonth->month)
            ->sum('amount');

        $lastIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('transaction_date', $lastMonth->year)
            ->whereMonth('transaction_date', $lastMonth->month)
            ->sum('amount');

        $incomeChange = 0;
        if ($lastIncome > 0) {
            $incomeChange = (($currentIncome - $lastIncome) / $lastIncome) * 100;
        }

        // Expense comparison
        $currentExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('transaction_date', $currentMonth->year)
            ->whereMonth('transaction_date', $currentMonth->month)
            ->sum('amount');

        $lastExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('transaction_date', $lastMonth->year)
            ->whereMonth('transaction_date', $lastMonth->month)
            ->sum('amount');

        $expenseChange = 0;
        if ($lastExpense > 0) {
            $expenseChange = (($currentExpense - $lastExpense) / $lastExpense) * 100;
        }

        // Profit comparison
        $currentProfit = $currentIncome - $currentExpense;
        $lastProfit = $lastIncome - $lastExpense;

        $profitChange = 0;
        if ($lastProfit != 0) {
            $profitChange = (($currentProfit - $lastProfit) / abs($lastProfit)) * 100;
        }

        // 6. INCOME VS EXPENSE TREND (6 MONTHS) untuk Chart
        $months = [];
        $incomeData = [];
        $expenseData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);

            $months[] = $date->format('M');

            $income = Transaction::where('user_id', $userId)
                ->where('type', 'income')
                ->whereYear('transaction_date', $date->year)
                ->whereMonth('transaction_date', $date->month)
                ->sum('amount');

            $expense = Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereYear('transaction_date', $date->year)
                ->whereMonth('transaction_date', $date->month)
                ->sum('amount');

            $incomeData[] = $income;
            $expenseData[] = $expense;
        }

        // 7. Kirim variabel ke view dashboard
        return view('dashboard.dashboard', compact(
            'totalAssets',
            'totalIncome',
            'totalExpense',
            'totalRemaining',
            'unallocatedFunds',
            'recentTransactions',
            'currentIncome',
            'currentExpense',
            'incomeChange',
            'expenseChange',
            'profitChange',
            'months',
            'incomeData',
            'expenseData'
        ));
    }
}