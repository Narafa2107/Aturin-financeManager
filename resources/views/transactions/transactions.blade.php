@extends('layouts.aturin')
 
@section('content')
 
<div class="dashboard-page">
 
    @include('partials.sidebar')
 
    <main class="main-content">
 
        <!-- Title -->
        <div class="top-title">
            <h1 class="text-4xl font-bold">Transactions</h1>
        </div>
 
        <!-- Action Buttons -->
        <div class="action-group">
            <a href="{{ route('transactions.create') }}"
                class="income-btn">
                <i class="fa-solid fa-plus mr-2"></i>
                Add Transaction
            </a>
            <button class="export-btn">
                <i class="fa-solid fa-download mr-2"></i> Export
            </button>
        </div>
 
        <!-- Filter Bar -->
    <form method="GET" action="{{ route('transactions.index') }}">
        <div class="filter-card">
 
            <div class="filter-top">
                <!-- Search -->
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                    <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search transactions..."
                            class="search-input"
                        />
                </div>
 
                <!-- Type Dropdown -->
                <select name="type" class="filter-select">
                    <option value="">All Types</option>
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
 
                <!-- Category Dropdown -->
                <select name="type" class="filter-select">
                    <option value="">All Categories</option>
                    <option value="marketing">Marketing</option>
                    <option value="sales">Sales</option>
                    <option value="operations">Operations</option>
                </select>
            </div>
 
            <div class="filter-bottom">
                <!-- Date Range -->
                <input type="date" class="date-input" placeholder="dd/mm/yyyy" />
                <span class="text-gray-400 text-sm">to</span>
                <input type="date" class="date-input" placeholder="dd/mm/yyyy" />
            </div>
 
        </div>
    </form>
 
        <!-- Transaction Table -->
        <div class="table-card">
 
            <p class="table-title">Title</p>
 
            <table class="transaction-table">
                <thead>
                    <tr class="table-header-row">
                        <th class="table-col-letter">A</th>
                        <th class="table-col-letter">B</th>
                        <th class="table-col-letter">C</th>
                        <th class="table-col-letter">D</th>
                        <th class="table-col-letter">E</th>
                        <th class="table-col-letter">F</th>
                        <th class="table-col-letter">G</th>
                    </tr>
                        <tr class="table-label-row">
                        <th class="table-cell">Date</th>
                        <th class="table-cell">Type</th>
                        <th class="table-cell">Description</th>
                        <th class="table-cell">Category</th>
                        <th class="table-cell">Amount</th>
                        <th class="table-cell">Receipt</th>
                        <th class="table-cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                     @foreach ($transactions as $transaction)
                        <tr class="table-row">

                            <td class="table-cell">
                                @if($transaction->type == 'income')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                        Income
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                        Expense
                                    </span>
                                @endif
                            </td>

                            <td class="table-cell">
                                {{ ucfirst($transaction->type) }}
                            </td>

                            <td class="table-cell">
                                {{ $transaction->description }}
                            </td>

                            <td class="table-cell">
                                {{ $transaction->category }}
                            </td>

                            <td class="table-cell">
                                Rp {{ number_format($transaction->amount,0,',','.') }}
                            </td>

                            <td class="table-cell">
                                @if($transaction->receipt)
                                    <a href="{{ asset('storage/'.$transaction->receipt) }}">
                                        View
                                    </a>
                                @endif
                            </td>

                            <td class="table-cell">

                                <a href="{{ route('transactions.edit', $transaction->id) }}"
                                class="text-blue-600 hover:underline">
                                    Edit
                                </a>

                                |

                                <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                    method="POST"
                                    class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-red-600 hover:underline"
                                        onclick="return confirm('Delete this transaction?')">
                                        Delete
                                    </button>

                                </form>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
 
        </div>
 
    </main>
 
</div>
 
@endsection