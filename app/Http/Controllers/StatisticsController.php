<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StatisticsController extends Controller
{
    public function exportPdf(Request $request)
    {
        $userId = auth()->id();

        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        $transactions = Transaction::where('user_id', $userId)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->orderBy('transaction_date')
            ->get();

        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $netProfit = $totalIncome - $totalExpense;

        $pdf = Pdf::loadView(
            'statistics.report-pdf',
            compact(
                'transactions',
                'totalIncome',
                'totalExpense',
                'netProfit',
                'month',
                'year'
            )
        );

        return $pdf->download("financial-report-{$month}-{$year}.pdf");
    }
    public function index(Request $request)
    {
        $period = $request->period;

    if ($period) {
        [$year, $month] = explode('-', $period);
    } else {
        $month = now()->month;
        $year = now()->year;
    }
        
        $userId = auth()->id();

        /*
        |--------------------------------------------------------------------------
        | SUMMARY CARDS
        |--------------------------------------------------------------------------
        */

        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $netProfit = $totalIncome - $totalExpense;
        $currentDate = Carbon::create($year, $month);

        $prev = $currentDate->copy()->subMonth();
        $next = $currentDate->copy()->addMonth();
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
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        /*
        |--------------------------------------------------------------------------
        | Income Comparison
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Expense Comparison
        |--------------------------------------------------------------------------
        */

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

        $currentProfit = $currentIncome - $currentExpense;
        $lastProfit = $lastIncome - $lastExpense;

        $profitChange = 0;

        if ($lastProfit != 0) {
            $profitChange = (($currentProfit - $lastProfit) / abs($lastProfit)) * 100;
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
            'expenseCategories',
            'incomeChange',
            'expenseChange',
            'profitChange',
            'month',
            'year'
        ));
    }
}
