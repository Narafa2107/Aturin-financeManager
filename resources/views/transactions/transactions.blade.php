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
            <button class="income-btn">
                <i class="fa-solid fa-plus mr-2"></i> Add Transaction
            </button>
            <button class="export-btn">
                <i class="fa-solid fa-download mr-2"></i> Export
            </button>
        </div>
 
        <!-- Filter Bar -->
        <div class="filter-card">
 
            <div class="filter-top">
                <!-- Search -->
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                    <input type="text" placeholder="Search transactions..." class="search-input" />
                </div>
 
                <!-- Type Dropdown -->
                <select class="filter-select">
                    <option value="">All Types</option>
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
 
                <!-- Category Dropdown -->
                <select class="filter-select">
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
                    </tr>
                    <tr class="table-label-row">
                        <th class="table-cell">Date</th>
                        <th class="table-cell">Description</th>
                        <th class="table-cell">Category</th>
                        <th class="table-cell">Amount</th>
                        <th class="table-cell">Receipt</th>
                        <th class="table-cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                     @for ($i = 2; $i <= 11; $i++)
                        <tr class="table-row">
                            <td class="table-cell row-number">{{ $i }}</td>
                            <td class="table-cell"></td>
                            <td class="table-cell"></td>
                            <td class="table-cell"></td>
                            <td class="table-cell"></td>
                            <td class="table-cell"></td>
                        </tr>
                    @endfor
                </tbody>
            </table>
 
        </div>
 
    </main>
 
</div>
 
@endsection