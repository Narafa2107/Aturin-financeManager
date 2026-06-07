<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
{
    $query = auth()->user()->transactions();

    if ($request->search) {
        $query->where('description', 'like', '%'.$request->search.'%');
    }

    if ($request->type) {
        $query->where('type', $request->type);
    }

    if ($request->category) {
        $query->where('category', $request->category);
    }

    $transactions = $query->latest()->get();

    return view('transactions.transactions', compact('transactions'));
}

    public function store(Request $request)
{
    $validated = $request->validate([
        'type' => 'required',
        'description' => 'required',
        'category' => 'required',
        'amount' => 'required|numeric',
        'transaction_date' => 'required|date',
        'receipt' => 'nullable|image'
    ]);

    if ($request->hasFile('receipt')) {

        $validated['receipt'] =
            $request->file('receipt')
            ->store('receipts', 'public');
    }

    $validated['user_id'] = auth()->id();

    Transaction::create($validated);

    return redirect()->route('transactions.index');
}
public function create()
{
    return view('transactions.create');
}
public function edit(Transaction $transaction)
{
    if ($transaction->user_id !== auth()->id()) {
        abort(403);
    }

    return view(
        'transactions.edit',
        compact('transaction')
    );
}
public function update(
    Request $request,
    Transaction $transaction
) {

    if ($transaction->user_id !== auth()->id()) {
        abort(403);
    }

    $validated = $request->validate([
        'type' => 'required',
        'description' => 'required',
        'category' => 'nullable',
        'amount' => 'required|numeric',
        'transaction_date' => 'required|date',
    ]);

    $transaction->update($validated);

    return redirect()
        ->route('transactions.index')
        ->with('success', 'Transaction updated');
}
public function destroy(Transaction $transaction)
{
    if ($transaction->user_id !== auth()->id()) {
        abort(403);
    }

    $transaction->delete();

    return redirect()
        ->route('transactions.index')
        ->with('success', 'Transaction deleted');
}
}
