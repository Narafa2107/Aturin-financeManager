<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\AIInsightService;
use Carbon\Carbon;

class InsightController extends Controller
{
    public function index(AIInsightService $ai)
    {
        $user = auth()->user();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $lastMonth = Carbon::now()->subMonth();

        // THIS MONTH
        $income = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->sum('amount');

        $expense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->sum('amount');

        // LAST MONTH
        $lastIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereMonth('transaction_date', $lastMonth->month)
            ->whereYear('transaction_date', $lastMonth->year)
            ->sum('amount');

        $lastExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $lastMonth->month)
            ->whereYear('transaction_date', $lastMonth->year)
            ->sum('amount');

        $incomeGrowth = $lastIncome > 0
            ? (($income - $lastIncome) / $lastIncome) * 100
            : 0;

        $expenseGrowth = $lastExpense > 0
            ? (($expense - $lastExpense) / $lastExpense) * 100
            : 0;

        $AIinsights = $ai->generate([
            'income' => $income,
            'expense' => $expense,
            'income_growth' => round($incomeGrowth, 2),
            'expense_growth' => round($expenseGrowth, 2),
        ]);
        return view(
            'insights.insights',
            compact('AIinsights')
        );
    }
}   