<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        /*
        |--------------------------------------------------------------------------
        | SUMMARY CARDS
        |--------------------------------------------------------------------------
        */

        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');

        $netProfit = $totalIncome - $totalExpense;

        /*
        |--------------------------------------------------------------------------
        | INCOME VS EXPENSE TREND (6 MONTHS)
        |--------------------------------------------------------------------------
        */

        $months = [];
        $incomeData = [];
        $expenseData = [];
        $profitData = [];
        $categoryLabels = [];
        $categoryTotals = [];

        
        $expenseCategories = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        foreach ($expenseCategories as $item) {
        $categoryLabels[] = $item->category ?? 'Uncategorized';
        $categoryTotals[] = (float) $item->total;
        }

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
            $profitData[] = round($income - $expense, 2);
        }

        return view('statistics.statistics', compact(
            'totalIncome',
            'totalExpense',
            'netProfit',
            'months',
            'incomeData',
            'expenseData',
            'profitData',
            'categoryLabels',
            'categoryTotals',
            'expenseCategories'
        ));
    }
}
