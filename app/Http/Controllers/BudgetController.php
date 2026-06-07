<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\BudgetSource;
// use App\Models\Transaction; // <-- Buka komen ini jika model transaksi temanmu sudah jadi

class BudgetController extends Controller
{
    /**
     * Menampilkan Dashboard Budget dengan Perhitungan 4 Card Utama
     */
    public function index()
    {
        $userId = auth()->id();

        // 1. Ambil data alokasi budget kategori milik user
        $budgets = Budget::where('user_id', $userId)->get();

        // 2. HITUNG TOTAL SUMBER DANA (Dari tabel budget_sources yang baru dibuat)
        $totalSource = BudgetSource::where('user_id', $userId)->sum('amount');

        // 3. AMBIL DATA TRANSAKSI PEMASUKAN & PENGELUARAN (Dari tabel temanmu)
        // Sementara di-set 0 dulu agar tidak error jika tabel temanmu belum selesai koding
        $totalIncome = 0; 
        $totalExpense = 0;

        // JIKA TABEL TEMANMU SUDAH JADI, hapus angka 0 di atas dan aktifkan kode di bawah ini:
        // $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
        // $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');

        // 4. HITUNG RUMUS 4 CARD UTAMA SESUAI KESEPAKATAN
        // Card 1: Total Assets (Uang kas nyata saat ini)
        $totalAssets = $totalSource + ($totalIncome - $totalExpense);

        // Card 3: Total Allocated (Total jatah anggaran yang sudah disebar ke kategori)
        $totalAllocated = Budget::where('user_id', $userId)->sum('allocated_amount');

        // Card 2: Unallocated Funds (Sisa uang nyata yang masih bebas dialokasikan ke kategori)
        $unallocatedFunds = $totalAssets - $totalAllocated;

        // Card 4: Total Remaining Budget (Sisa jatah jatah anggaran global yang belum dibelanjakan)
        $totalRemaining = $totalAllocated - $totalExpense;

        // 5. Lempar semua variabel perhitungan ke halaman Blade
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
     * Logika Modal 1: Allocate Budget (Sistem Top-Up Akumulasi Kategori Bulan Ini)
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string',
            'allocated_amount' => 'required|numeric|min:1000',
        ]);

        $userId = auth()->id();
        $currentMonthYear = date('Y-m'); // Otomatis mengunci ke bulan berjalan saat ini

        // Cari tahu apakah kategori tersebut sudah pernah diinput bulan ini
        $existingBudget = Budget::where('user_id', $userId)
                                ->where('category_name', $request->category_name)
                                ->where('month_year', $currentMonthYear)
                                ->first();

        if ($existingBudget) {
            // JIKA SUDAH ADA: Nominalnya ditambahkan (Sistem Top-Up)
            $existingBudget->allocated_amount += $request->allocated_amount;
            $existingBudget->save();
        } else {
            // JIKA BELUM ADA: Buat kotak kategori baru
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
     * Logika Modal 2: Add New Budget Source (Menyimpan Sumber Dana / Modal Baru)
     */
    public function storeSource(Request $request)
    {
        $request->validate([
            'source_name' => 'required|string',
            'amount' => 'required|numeric|min:1000',
        ]);

        // Simpan ke tabel budget_sources
        BudgetSource::create([
            'user_id' => auth()->id(),
            'source_name' => $request->source_name,
            'amount' => $request->amount,
        ]);

        return redirect()->route('budget')->with('success', 'Budget source added successfully!');
    }
}