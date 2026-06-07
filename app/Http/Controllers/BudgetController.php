<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\BudgetSource;
use App\Models\Transaction; 

class BudgetController extends Controller
{
    /**
     * Menampilkan Dashboard Budget dengan Perhitungan Akurat Terintegrasi
     */
    public function index()
    {
        $userId = auth()->id();

        // 1. Ambil data alokasi jatah anggaran kategori milik user
        $rawBudgets = Budget::where('user_id', $userId)->get();

        // 2. HITUNG TOTAL SUMBER DANA / MODAL ASET
        $totalSource = BudgetSource::where('user_id', $userId)->sum('amount');

        // 3. HITUNG TOTAL TRANSAKSI GLOBAL (PEMASUKAN & PENGELUARAN)
        $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');

        // 4. HITUNG RUMUS 4 CARD UTAMA SEJAJAR
        $totalAssets = $totalSource + ($totalIncome - $totalExpense);
        $totalAllocated = Budget::where('user_id', $userId)->sum('allocated_amount');
        $unallocatedFunds = $totalAssets - $totalAllocated;
        $totalRemaining = $totalAllocated - $totalExpense;

        // 5. LOGIKA INTEGRASI: Hitung pengeluaran per kategori divisi secara otomatis
        $budgets = $rawBudgets->map(function ($budget) use ($userId) {
            // Hitung total expense yang dilakukan oleh user ini untuk kategori spesifik ini
            $categorySpent = Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->where('category', $budget->category_name)
                ->sum('amount');

            // Hitung sisa budget untuk kategori ini
            $categoryRemaining = $budget->allocated_amount - $categorySpent;

            // Hitung persentase pemakaian untuk kemajuan progress bar (maksimal 100%)
            $percentageUsed = $budget->allocated_amount > 0 
                ? min(($categorySpent / $budget->allocated_amount) * 100, 100) 
                : 0;

            // Masukkan variabel baru ini sebagai properti objek budget agar bisa dibaca di Blade
            $budget->spent = $categorySpent;
            $budget->remaining = $categoryRemaining;
            $budget->percentage_used = $percentageUsed;

            return $budget;
        });

        // 6. Lempar semua variabel perhitungan ke halaman Blade
        return view('budget.budget', compact(
            'budgets', 
            'totalAssets', 
            'unallocatedFunds', 
            'totalAllocated', 
            'totalRemaining',
            'totalExpense'
        ));
    }

    /**
     * Logika Modal 1: Allocate Budget (Sistem Top-Up)
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string',
            'allocated_amount' => 'required|numeric|min:1000',
        ]);

        $userId = auth()->id();
        $currentMonthYear = date('Y-m'); 

        $existingBudget = Budget::where('user_id', $userId)
                                ->where('category_name', $request->category_name)
                                ->where('month_year', $currentMonthYear)
                                ->first();

        if ($existingBudget) {
            $existingBudget->allocated_amount += $request->allocated_amount;
            $existingBudget->save();
        } else {
            Budget::create([
                'user_id' => $userId,
                'category_name' => $request->category_name,
                'allocated_amount' => $request->allocated_amount,
                'month_year' => $currentMonthYear,
            ]);
        }

        return redirect()->route('budget')->with('success', 'Budget allocated successfully!');
    }

    /**
     * Logika Modal 2: Add New Budget Source
     */
    public function storeSource(Request $request)
    {
        $request->validate([
            'source_name' => 'required|string',
            'amount' => 'required|numeric|min:1000',
        ]);

        BudgetSource::create([
            'user_id' => auth()->id(),
            'source_name' => $request->source_name,
            'amount' => $request->amount,
        ]);

        return redirect()->route('budget')->with('success', 'Budget source added successfully!');
    }
}