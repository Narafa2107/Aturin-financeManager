@extends('layouts.aturin')

@section('content')

<div class="dashboard-page">

    @include('partials.sidebar')



    <!-- MAIN -->
    <main class="main-content">

        <!-- Title -->
        <div class="top-title">
            <h1 class="text-4xl font-bold">Dashboard</h1>
        </div>

        <!-- Action Buttons -->
        <div class="action-group">
            <button class="income-btn">
                <i class="fa-solid fa-plus mr-2"></i> Add Income
            </button>
            <button class="expense-btn">
                <i class="fa-solid fa-plus mr-2"></i> Add Expense
            </button>
        </div>

        <!-- Summary Cards -->
        <div class="summary-grid">

            <div class="summary-card income-card">
                <div class="flex justify-between items-start">
                    <p class="text-sm text-gray-600 font-medium">Total Income</p>
                    <i class="fa-solid fa-arrow-trend-up text-green-600 text-lg"></i>
                </div>
                <h2 class="text-2xl font-bold mt-3">Rp 10.500.000</h2>
                <p class="text-xs text-green-700 mt-1">+4,2%</p>
            </div>

            <div class="summary-card expense-card">
                <div class="flex justify-between items-start">
                    <p class="text-sm text-gray-600 font-medium">Total Expenses</p>
                    <i class="fa-solid fa-arrow-trend-down text-red-600 text-lg"></i>
                </div>
                <h2 class="text-2xl font-bold mt-3">Rp 12.231.420</h2>
                <p class="text-xs text-red-700 mt-1">-7,1%</p>
            </div>

            <div class="summary-card expense-card">
                <div class="flex justify-between items-start">
                    <p class="text-sm text-gray-600 font-medium">Net Profit</p>
                    <i class="fa-solid fa-arrow-trend-down text-red-600 text-lg"></i>
                </div>
                <h2 class="text-2xl font-bold mt-3">Rp 3.500.000</h2>
                <p class="text-xs text-red-700 mt-1">-4,2%</p>
            </div>

            <div class="summary-card budget-card">
                <div class="flex justify-between items-start">
                    <p class="text-sm text-gray-600 font-medium">Budget</p>
                </div>
                <h2 class="text-2xl font-bold mt-3">Rp 5.000.000</h2>
            </div>

        </div>

        <!-- Budget Alert -->
        <div class="budget-alert">
            <div class="alert-side"></div>
            <div class="alert-content">
                <p class="font-bold text-sm">Budget Alert</p>
                <p class="text-sm mt-0.5">Estimated expense by the end of April : Rp 5.000.000</p>
            </div>
        </div>

        <!-- Chart + Recent Transaction -->
        <div class="middle-grid">

            <!-- Chart -->
            <div class="chart-card">
                <h3 class="text-lg font-bold mb-4">Income VS Expenses</h3>
                <div class="chart-placeholder flex items-center justify-center text-gray-400">
                    <i class="fa-solid fa-chart-column text-5xl opacity-30"></i>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="transaction-card">
                <h3 class="text-lg font-bold mb-5">Recent Transaction</h3>

                <div class="transaction-list">

                    <div class="transaction-item">
                        <div class="transaction-icon expense-icon">
                            <i class="fa-solid fa-arrow-down-right"></i>
                        </div>
                        <div class="transaction-info">
                            <p class="font-semibold text-sm">Google Ads Campaign</p>
                            <p class="text-xs text-gray-500 mt-0.5">May 11, 2026</p>
                        </div>
                        <span class="transaction-amount text-red-500 font-bold">- $5,000</span>
                    </div>

                    <div class="transaction-item">
                        <div class="transaction-icon income-icon">
                            <i class="fa-solid fa-arrow-up-right"></i>
                        </div>
                        <div class="transaction-info">
                            <p class="font-semibold text-sm">Client Payment - Project A</p>
                            <p class="text-xs text-gray-500 mt-0.5">May 11, 2026</p>
                        </div>
                        <span class="transaction-amount text-green-600 font-bold">+ $5,000</span>
                    </div>

                    <div class="transaction-item">
                        <div class="transaction-icon income-icon">
                            <i class="fa-solid fa-arrow-up-right"></i>
                        </div>
                        <div class="transaction-info">
                            <p class="font-semibold text-sm">Client Payment - Project A</p>
                            <p class="text-xs text-gray-500 mt-0.5">May 11, 2026</p>
                        </div>
                        <span class="transaction-amount text-green-600 font-bold">+ $5,000</span>
                    </div>

                    <div class="transaction-item">
                        <div class="transaction-icon expense-icon">
                            <i class="fa-solid fa-arrow-down-right"></i>
                        </div>
                        <div class="transaction-info">
                            <p class="font-semibold text-sm">Google Ads Campaign</p>
                            <p class="text-xs text-gray-500 mt-0.5">May 11, 2026</p>
                        </div>
                        <span class="transaction-amount text-red-500 font-bold">- $5,000</span>
                    </div>

                </div>
            </div>

        </div>

        <!-- Monthly Insight -->
        <div class="insight-section">
            <h3 class="text-lg font-bold mb-5">Monthly Insight</h3>
            <div class="insight-grid">

                <div class="insight-red">
                    <i class="fa-solid fa-thumbs-down text-red-500 text-2xl mb-3"></i>
                    <p class="text-sm text-gray-700">Your spending decreased by <strong>15%</strong> compared to last month</p>
                </div>

                <div class="insight-green">
                    <i class="fa-solid fa-thumbs-up text-green-600 text-2xl mb-3"></i>
                    <p class="text-sm text-gray-700">Revenue from Product Sales increased by <strong>23%</strong></p>
                </div>

                <div class="insight-purple">
                    <i class="fa-solid fa-wrench text-purple-500 text-2xl mb-3"></i>
                    <p class="text-sm text-gray-700">Consider reducing Marketing expenses - ROI below target</p>
                </div>

            </div>
        </div>

    </main>

</div>

@endsection