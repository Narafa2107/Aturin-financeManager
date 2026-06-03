@extends('layouts.aturin')

@section('content')

<div class="dashboard-page">

    @include('partials.sidebar')

    <!-- MAIN -->
    <main class="main-content">

        <!-- Title + Filter Bar -->
        <div class="top-title flex items-center justify-between">
            <h1 class="text-4xl font-bold">Statistics</h1>

            <div class="flex items-center gap-3">
                {{-- Date Chip --}}
                <div class="flex items-center gap-2 px-4 py-2 rounded-xl border border-white/20 bg-white/5 text-sm font-medium text-white/80">
                    <i class="fa-regular fa-calendar text-white/50"></i>
                    May 2026
                </div>

                {{-- Period Dropdown --}}
                <div class="relative">
                    <select class="appearance-none px-4 py-2 pr-9 rounded-xl border border-white/20 bg-white/5 text-sm font-medium text-white/80 cursor-pointer focus:outline-none">
                        <option class="bg-gray-900">This Month</option>
                        <option class="bg-gray-900">Last Month</option>
                        <option class="bg-gray-900">Last 3 Months</option>
                        <option class="bg-gray-900">This Year</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-white/40 text-xs pointer-events-none"></i>
                </div>

                {{-- Export Button --}}
                <button class="income-btn flex items-center gap-2">
                    <i class="fa-regular fa-file-lines"></i>
                    Export Report
                </button>
            </div>
        </div>

        <!-- Summary Cards (3-col) -->
        <div class="grid grid-cols-3 gap-5">

            <div class="summary-card income-card">
                <div class="flex justify-between items-start">
                    <p class="text-sm text-gray-600 font-medium">Total Income</p>
                    <i class="fa-solid fa-arrow-trend-up text-green-600 text-lg"></i>
                </div>
                <h2 class="text-2xl font-bold mt-3">Rp 10.500.000</h2>
                <p class="text-xs text-green-700 mt-1">+4,2% from last month</p>
            </div>

            <div class="summary-card expense-card">
                <div class="flex justify-between items-start">
                    <p class="text-sm text-gray-600 font-medium">Total Expenses</p>
                    <i class="fa-solid fa-arrow-trend-down text-red-600 text-lg"></i>
                </div>
                <h2 class="text-2xl font-bold mt-3">Rp 12.231.420</h2>
                <p class="text-xs text-red-700 mt-1">-7,1% from last month</p>
            </div>

            <div class="summary-card expense-card">
                <div class="flex justify-between items-start">
                    <p class="text-sm text-gray-600 font-medium">Net Profit</p>
                    <i class="fa-solid fa-arrow-trend-down text-red-600 text-lg"></i>
                </div>
                <h2 class="text-2xl font-bold mt-3">Rp 3.500.000</h2>
                <p class="text-xs text-red-700 mt-1">-4,2% from last month</p>
            </div>

        </div>

        <!-- Trend Charts -->
        <div class="middle-grid">

            <!-- Income vs Expenses Trend -->
            <div class="chart-card">
                <h3 class="text-lg font-bold mb-4">Incomes vs Expenses Trend</h3>
                <div class="chart-placeholder flex items-center justify-center text-gray-400">
                    <i class="fa-solid fa-chart-line text-5xl opacity-30"></i>
                </div>
            </div>

            <!-- Profit Trend -->
            <div class="chart-card">
                <h3 class="text-lg font-bold mb-4">Profit Trend (6 Months)</h3>
                <div class="chart-placeholder flex items-center justify-center text-gray-400">
                    <i class="fa-solid fa-chart-area text-5xl opacity-30"></i>
                </div>
            </div>

        </div>

        <!-- Expense Breakdown by Category -->
        <div class="chart-card">
            <h3 class="text-lg font-bold mb-6">Expense Breakdown by Category</h3>

            <div class="grid grid-cols-2 gap-8 items-center">

                {{-- Donut placeholder --}}
                <div class="chart-placeholder flex items-center justify-center text-gray-400" style="height: 260px;">
                    <i class="fa-solid fa-chart-pie text-5xl opacity-30"></i>
                </div>

                {{-- Legend + Progress Bars --}}
                <div class="flex flex-col gap-5">

                    {{-- Marketing --}}
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-red-500 flex-shrink-0"></span>
                                <span class="text-sm font-semibold text-gray-800">Marketing</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Rp -</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: 38.6%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">38.6% of total expenses</p>
                    </div>

                    {{-- Operations --}}
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-blue-500 flex-shrink-0"></span>
                                <span class="text-sm font-semibold text-gray-800">Operations</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Rp -</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 27.9%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">27.9% of total expenses</p>
                    </div>

                    {{-- Technology --}}
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-purple-500 flex-shrink-0"></span>
                                <span class="text-sm font-semibold text-gray-800">Technology</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Rp -</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: 19.3%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">19.3% of total expenses</p>
                    </div>

                    {{-- Salaries --}}
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-yellow-400 flex-shrink-0"></span>
                                <span class="text-sm font-semibold text-gray-800">Salaries</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Rp -</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width: 14.2%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">14.2% of total expenses</p>
                    </div>

                </div>
            </div>
        </div>

        <!-- Monthly Insight (reused from dashboard) -->
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