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
                <form method="GET" action="{{ route('statistics') }}">
                    <div class="flex items-center gap-2 px-4 py-2 rounded-xl border border-white/20 bg-white/5">
                        <input
                            type="month"
                            name="period"
                            value="{{ sprintf('%04d-%02d', $year, $month) }}"
                            onchange="this.form.submit()"
                            class="bg-transparent text-sm font-medium text-white/80 border-white/0 outline-none"
                        >
                    </div>
                </form>

                {{-- Export Button --}}
                <a href="{{ route('statistics.export.pdf', [
                    'month' => $month,
                    'year' => $year
                ]) }}"
                class="export-btn">
                    <i class="fa-solid fa-download mr-2"></i>
                    Export PDF
                </a>
            </div>
        </div>
        
        <!-- Summary Cards (3-col) -->
        <div class="grid grid-cols-3 gap-5">

            {{-- Income --}}
            <div class="summary-card {{ $incomeChange >= 0 ? 'income-card' : 'expense-card' }}">
                <div class="flex justify-between items-start">
                    <p class="text-sm text-gray-600 font-medium">Total Income</p>

                    @if($incomeChange >= 0)
                        <i class="fa-solid fa-arrow-trend-up text-green-600 text-lg"></i>
                    @else
                        <i class="fa-solid fa-arrow-trend-down text-red-600 text-lg"></i>
                    @endif
                </div>

                <h2 class="text-2xl font-bold mt-3">
                    Rp {{ number_format($totalIncome, 0, ',', '.') }}
                </h2>

                <p class="text-xs mt-1 {{ $incomeChange >= 0 ? 'text-green-700' : 'text-red-700' }}">
                    {{ number_format($incomeChange,1) }}% from last month
                </p>
            </div>

            {{-- Expense --}}
            <div class="summary-card {{ $expenseChange <= 0 ? 'income-card' : 'expense-card' }}">
                <div class="flex justify-between items-start">
                    <p class="text-sm text-gray-600 font-medium">Total Expenses</p>

                    @if($expenseChange <= 0)
                        <i class="fa-solid fa-arrow-trend-down text-green-600 text-lg"></i>
                    @else
                        <i class="fa-solid fa-arrow-trend-up text-red-600 text-lg"></i>
                    @endif
                </div>

                <h2 class="text-2xl font-bold mt-3">
                    Rp {{ number_format($totalExpense, 0, ',', '.') }}
                </h2>

                <p class="text-xs mt-1 {{ $expenseChange <= 0 ? 'text-green-700' : 'text-red-700' }}">
                    {{ number_format(abs($expenseChange),1) }}% from last month
                </p>
            </div>

            {{-- Profit --}}
            <div class="summary-card {{ $profitChange >= 0 ? 'income-card' : 'expense-card' }}">
                <div class="flex justify-between items-start">
                    <p class="text-sm text-gray-600 font-medium">Net Profit</p>

                    @if($profitChange >= 0)
                        <i class="fa-solid fa-arrow-trend-up text-green-600 text-lg"></i>
                    @else
                        <i class="fa-solid fa-arrow-trend-down text-red-600 text-lg"></i>
                    @endif
                </div>

                <h2 class="text-2xl font-bold mt-3">
                    Rp {{ number_format($netProfit, 0, ',', '.') }}
                </h2>

                <p class="text-xs mt-1 {{ $profitChange >= 0 ? 'text-green-700' : 'text-red-700' }}">
                    {{ number_format($profitChange,1) }}% from last month
                </p>
            </div>

        </div>
        <!-- Trend Charts -->
        <div class="middle-grid">

            <!-- Income vs Expenses Trend -->
            <div class="chart-card">
                <h3 class="text-lg font-bold mb-4">Incomes vs Expenses Trend</h3>
                <div id="incomeExpenseChart"></div>
            </div>

            <!-- Profit Trend -->
            <div class="chart-card">
                <h3 class="text-lg font-bold mb-4">Profit Trend (6 Months)</h3>
                <div id="profitChart"></div>
            </div>

        </div>

        <!-- Expense Breakdown by Category -->
        <div class="chart-card">
            <h3 class="text-lg font-bold mb-6">Expense Breakdown by Category</h3>

            <div class="grid grid-cols-2 gap-8 items-center">

                {{-- Donut placeholder --}}
                <div id="expenseDonutChart"></div>

                {{-- Legend + Progress Bars --}}
                <div class="flex flex-col gap-5">

                   <div class="flex flex-col gap-5">

                        @php
                            $totalExpenseAmount = array_sum($categoryTotals);
                        @endphp

                        @foreach($expenseCategories as $category)

                            @php
                                $percentage = $totalExpenseAmount > 0
                                    ? ($category->total / $totalExpenseAmount) * 100
                                    : 0;
                            @endphp

                            <div>

                                <div class="flex justify-between items-center mb-1">

                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-green-500"></span>

                                        <span class="text-sm font-semibold text-gray-800">
                                            {{ ucfirst($category->category) }}
                                        </span>
                                    </div>

                                    <span class="text-sm font-semibold text-gray-700">
                                        Rp {{ number_format($category->total, 0, ',', '.') }}
                                    </span>

                                </div>

                                <div class="w-full bg-gray-200 rounded-full h-2">

                                    <div
                                        class="bg-green-500 h-2 rounded-full"
                                        style="width: {{ $percentage }}%">
                                    </div>

                                </div>

                                <p class="text-xs text-gray-400 mt-1">
                                    {{ number_format($percentage, 1) }}% of total expenses
                                </p>

                            </div>

                        @endforeach

                    </div>

                </div>
            </div>
        </div>


<!-- Income vs Expense Line Chart -->
<script>
var options = {
    chart: {
        type: 'line',
        height: 350
    },

    series: [
        {
            name: 'Income',
            data: @json($incomeData)
        },
        {
            name: 'Expense',
            data: @json($expenseData)
        }
    ],

    xaxis: {
        categories: @json($months)
    }
};

var chart = new ApexCharts(
    document.querySelector("#incomeExpenseChart"),
    options
);

chart.render();
</script>
<!-- Profit Trend Area Chart -->
<script>
var profitOptions = {

    chart: {
        type: 'area',
        height: 350,
        toolbar: {
            show: false
        }
    },

    series: [{
        name: 'Profit',
        data: @json($profitData)
    }],

    xaxis: {
        categories: @json($months)
    },

    stroke: {
        curve: 'smooth'
    },

    dataLabels: {
        enabled: false
    }
};

var profitChart = new ApexCharts(
    document.querySelector("#profitChart"),
    profitOptions
);

profitChart.render();
</script>
<!-- Expense Breakdown Donut Chart -->
<script>
var donutOptions = {

    chart: {
        type: 'donut',
        height: 300
    },

    series: @json($categoryTotals),

    labels: @json($categoryLabels),

    legend: {
        position: 'bottom'
    },

    dataLabels: {
        enabled: true
    }
};

var donutChart = new ApexCharts(
    document.querySelector("#expenseDonutChart"),
    donutOptions
);

donutChart.render();
</script>
@endsection