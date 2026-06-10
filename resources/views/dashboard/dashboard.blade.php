@extends('layouts.aturin')

@section('content')

<div class="dashboard-page">

    @include('partials.sidebar')

    <main class="main-content">

        <div class="top-title">
            <h1 class="text-4xl font-bold">Dashboard</h1>
        </div>

        <div class="summary-grid">

            <div class="summary-card rounded-2xl p-6 text-black" style="background: {{ $incomeChange > 0 ? 'linear-gradient(to bottom right, #dcfce7, #86efac)' : 'linear-gradient(to bottom right, #fee2e2, #fca5a5)' }};">
                <div class="flex justify-between items-start">
                    <p class="text-sm text-gray-600 font-medium">Current Income</p>
                    <i class="fa-solid {{ $incomeChange > 0 ? 'fa-arrow-trend-up text-green-600' : 'fa-arrow-trend-down text-red-600' }} text-lg"></i>
                </div>
                <h2 class="text-2xl font-bold mt-3">Rp {{ number_format($currentIncome, 0, ',', '.') }}</h2>
                <p class="text-xs {{ $incomeChange > 0 ? 'text-green-700' : 'text-red-700' }} mt-1">
                    {{ $incomeChange > 0 ? '+' : '' }}{{ number_format($incomeChange, 1) }}%
                </p>
            </div>

            <div class="summary-card rounded-2xl p-6 text-black" style="background: {{ $expenseChange > 0 ? 'linear-gradient(to bottom right, #fee2e2, #fca5a5)' : 'linear-gradient(to bottom right, #dcfce7, #86efac)' }};">
                <div class="flex justify-between items-start">
                    <p class="text-sm text-gray-600 font-medium">Current Expenses</p>
                    <i class="fa-solid {{ $expenseChange > 0 ? 'fa-arrow-trend-up text-red-600' : 'fa-arrow-trend-down text-green-600' }} text-lg"></i>
                </div>
                <h2 class="text-2xl font-bold mt-3">Rp {{ number_format($currentExpense, 0, ',', '.') }}</h2>
                <p class="text-xs {{ $expenseChange > 0 ? 'text-red-700' : 'text-green-700' }} mt-1">
                    {{ $expenseChange > 0 ? '+' : '' }}{{ number_format($expenseChange, 1) }}%
                </p>
            </div>

           <div class="summary-card rounded-2xl p-6 text-black" style="background: {{ $profitChange >= 0 ? 'linear-gradient(to bottom right, #dcfce7, #86efac)' : 'linear-gradient(to bottom right, #fee2e2, #fca5a5)' }};">
                <div class="flex justify-between items-start">
                    <p class="text-sm text-gray-600 font-medium">Net Profit</p>

                    @if($profitChange >= 0)
                        <i class="fa-solid fa-arrow-trend-up text-green-600 text-lg"></i>
                    @else
                        <i class="fa-solid fa-arrow-trend-down text-red-600 text-lg"></i>
                    @endif
                </div>
                <h2 class="text-2xl font-bold mt-3">Rp {{ number_format($currentIncome - $currentExpense, 0, ',', '.') }}</h2>

                <p class="text-xs mt-1 {{ $profitChange >= 0 ? 'text-green-700' : 'text-red-700' }}">
                    {{ number_format($profitChange,1) }}% from last month
                </p>
            </div>

            
            <div class="summary-card budget-card">
                <div class="flex justify-between items-start">
                    <p class="text-sm text-gray-600 font-medium">Remaining Budget</p>
                </div>
                <h2 class="text-2xl font-bold mt-3">Rp {{ number_format($totalRemaining, 0, ',', '.') }}</h2>
            </div>

        </div>

        <div class="budget-alert">
            <div class="alert-side"></div>
            <div class="alert-content">
                <p class="font-bold text-sm">Budget Alert</p>
                <p class="text-sm mt-0.5">Assets not yet allocated : Rp {{ number_format($unallocatedFunds, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="middle-grid">

            <div class="chart-card">
                <h3 class="text-lg font-bold mb-4">Income VS Expenses (6 Months)</h3>
                <div id="incomeExpenseChart"></div>
            </div>

            <div class="transaction-card">
                <h3 class="text-lg font-bold mb-5">Recent Transaction</h3>

                <div class="transaction-list">

                    @forelse($recentTransactions as $transaction)
                        <div class="transaction-item">
                            <div class="transaction-icon {{ $transaction->type == 'income' ? 'income-icon' : 'expense-icon' }}">
                                <i class="fa-solid {{ $transaction->type == 'income' ? 'fa-arrow-up-right' : 'fa-arrow-down-right' }}"></i>
                            </div>
                            <div class="transaction-info">
                                <p class="font-semibold text-sm">{{ $transaction->description }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $transaction->created_at->format('M d, Y') }}</p>
                            </div>
                            <span class="transaction-amount {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-500' }} font-bold">
                                {{ $transaction->type == 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400 italic text-sm">
                            No recent transactions yet.
                        </div>
                    @endforelse

                </div>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const chartOptions = {
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: true,
                            tools: {
                                download: false,
                                selection: true,
                                zoom: true,
                                zoomin: true,
                                zoomout: true,
                                pan: true,
                                reset: true
                            }
                        },
                        sparkline: {
                            enabled: false
                        }
                    },
                    series: [
                        {
                            name: 'Income',
                            data: @json($incomeData)
                        },
                        {
                            name: 'Expenses',
                            data: @json($expenseData)
                        }
                    ],
                    colors: ['#10b981', '#ef4444'],
                    stroke: {
                        curve: 'smooth',
                        width: 4
                    },
                    xaxis: {
                        categories: @json($months),
                        labels: {
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Amount (Rp)',
                            style: {
                                fontSize: '12px'
                            }
                        },
                        labels: {
                            formatter: function(value) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                            }
                        }
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        floating: false,
                        fontSize: '12px'
                    },
                    grid: {
                        borderColor: '#e5e7eb',
                        padding: {
                            left: 0,
                            right: 0
                        }
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.65,
                            opacityTo: 1,
                            stops: [20, 100, 100, 100]
                        }
                    },
                    tooltip: {
                        theme: 'light',
                        x: {
                            format: 'MMM'
                        },
                        y: {
                            formatter: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                };

                const chart = new ApexCharts(document.querySelector("#incomeExpenseChart"), chartOptions);
                chart.render();
            });
        </script>
    </main>

</div>

@endsection