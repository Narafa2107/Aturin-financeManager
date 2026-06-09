@extends('layouts.aturin')

@section('content')

<div class="dashboard-page">

    @include('partials.sidebar')

    <!-- MAIN -->
    <main class="main-content">

        <!-- Title -->
        <div class="top-title">
            <h1 class="text-4xl font-bold">Insights</h1>
        </div>

        <!-- Monthly Insight Banner -->
        <div style="background: linear-gradient(135deg, #2ecc40 0%, #1e8a28 100%); border-radius: 14px; padding: 20px 26px; display: flex; align-items: center; gap: 16px; box-shadow: 0 4px 20px rgba(46,204,64,0.25);">
            <div style="width:44px; height:44px; background:rgba(255,255,255,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-bolt text-white text-xl"></i>
            </div>
            <div>
                <p class="font-bold text-white" style="font-size:1rem; margin:0 0 3px 0;">Monthly Insight this Month</p>
                <p class="text-white" style="font-size:0.85rem; margin:0; opacity:0.85;">Calculating insight based on your current month financial data</p>
            </div>
        </div>

        <!-- Insight Cards Grid — reuse summary-grid class from dashboard -->
        <div class="summary-grid" style="margin-top:20px;">

            <!-- Revenue Growing -->
            <div class="summary-card" style="background:#e8f8ea; border-top:4px solid #2ecc40;">
                <div class="flex justify-between items-start">
                    <p class="text-sm font-semibold" style="color:#1a7a25;">{{ $AIinsights['revenue_title'] ?? 'Revenue Growing' }}</p>
                    <i class="fa-solid fa-arrow-trend-up" style="color:#2ecc40; font-size:1.1rem;"></i>
                </div>
                <p class="text-sm mt-3" style="color:#2d6b35; line-height:1.55;">{{ $AIinsights['revenue'] ?? 'Insight belum tersedia' }}</p>
            </div>

            <!-- Profits Rising -->
            <div class="summary-card" style="background:#e8effe; border-top:4px solid #4a6fd4;">
                <div class="flex justify-between items-start">
                    <p class="text-sm font-semibold" style="color:#2b4db0;">{{ $AIinsights['profits_title'] ?? 'Profits Rising' }}</p>
                    <i class="fa-solid fa-dollar-sign" style="color:#4a6fd4; font-size:1.1rem;"></i>
                </div>
                <p class="text-sm mt-3" style="color:#3d5a9e; line-height:1.55;">{{ data_get($AIinsights, 'profits', 'Insight belum tersedia') }}</p>
            </div>

            <!-- Budget Running Low -->
            <div class="summary-card" style="background:#fef9e7; border-top:4px solid #f0c040;">
                <div class="flex justify-between items-start">
                    <p class="text-sm font-semibold" style="color:#8a6a0a;">{{ $AIinsights['budget_title'] ?? 'Budget Running Low' }}</p>
                    <i class="fa-solid fa-triangle-exclamation" style="color:#f0c040; font-size:1.1rem;"></i>
                </div>
                <p class="text-sm mt-3" style="color:#7a6020; line-height:1.55;">{{ data_get($AIinsights, 'budget', 'Insight belum tersedia') }}</p>
            </div>

            <!-- High Expenses -->
            <div class="summary-card" style="background:#fce8f5; border-top:4px solid #d44abd;">
                <div class="flex justify-between items-start">
                    <p class="text-sm font-semibold" style="color:#a02898;">{{ $AIinsights['expenses_title'] ?? 'High Expenses' }}</p>
                    <i class="fa-solid fa-arrow-trend-down" style="color:#d44abd; font-size:1.1rem;"></i>
                </div>
                <p class="text-sm mt-3" style="color:#8a4080; line-height:1.55;">{{ data_get($AIinsights, 'expenses', 'Insight belum tersedia') }}</p>
            </div>

        </div>

        <!-- Strategic Recommendations Header — reuse budget-alert style -->
        <div class="budget-alert" style="background:white; border-left:none; border-radius:14px; padding:18px 22px; display:flex; align-items:center; gap:14px; box-shadow:0 2px 10px rgba(0,0,0,0.08); margin-top:8px;">
            <div style="width:38px; height:38px; background:rgba(46,204,64,0.12); border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-list-check" style="color:#1e8a28; font-size:1rem;"></i>
            </div>
            <div>
                <p class="font-bold text-sm" style="color:#111; margin:0 0 3px 0;">Strategic Recommendations</p>
                <p class="text-sm" style="color:#666; margin:0;">Make suggestions based on your financial statistics</p>
            </div>
        </div>

        <!-- Recommendation Cards — reuse insight-section & insight-grid -->
        <div style="display:flex; gap:16px; margin-top:8px; flex-wrap:wrap;">

                <!-- Optimize Expenses -->
                <div style="background:#daeefe; border-radius:12px; padding:20px 22px; border-top:4px solid #3a9fd4; flex:1; min-width:280px;">
                    <div class="flex justify-between items-start">
                        <p class="text-sm font-semibold" style="color:#1868a0;">{{ $AIinsights['recommendations'][0]['title'] }}</p>
                        <i class="fa-solid fa-sliders" style="color:#3a9fd4; font-size:1.1rem;"></i>
                    </div>
                    <p class="text-sm mt-3" style="color:#2a6a90; line-height:1.55;">{{ $AIinsights['recommendations'][0]['content'] }}</p>
                </div>

                <!-- Allocate Profits -->
                <div style="background:#e4f8ec; border-radius:12px; padding:20px 22px; border-top:4px solid #30d46e;flex:1; min-width:280px;">
                    <div class="flex justify-between items-start">
                        <p class="text-sm font-semibold" style="color:#148040;">{{ $AIinsights['recommendations'][1]['title'] }}</p>
                        <i class="fa-solid fa-layer-group" style="color:#30d46e; font-size:1.1rem;"></i>
                    </div>
                    <p class="text-sm mt-3" style="color:#267848; line-height:1.55;">{{ $AIinsights['recommendations'][1]['content'] }}</p>
                </div>
            
        </div>

        <!-- This Month vs Last Month Comparison Chart -->
        <div class="chart-card" style="margin-top:8px;">
            <h3 class="text-lg font-bold mb-4">This Month vs Last Month Comparison</h3>
            <div id="comparisonChart"></div>
        </div>

    </main>

</div>

<!-- Comparison Chart Script -->
<script>
var comparisonOptions = {
    chart: {
        type: 'bar',
        height: 350,
        toolbar: {
            show: true
        }
    },
    
    series: [
        {
            name: '{{ $comparisonData["monthLabel"] }}',
            data: [
                {{ $comparisonData["thisMonth"]["income"] }},
                {{ $comparisonData["thisMonth"]["expense"] }},
                {{ $comparisonData["thisMonth"]["profit"] }}
            ]
        },
        {
            name: '{{ $comparisonData["lastMonthLabel"] }}',
            data: [
                {{ $comparisonData["lastMonth"]["income"] }},
                {{ $comparisonData["lastMonth"]["expense"] }},
                {{ $comparisonData["lastMonth"]["profit"] }}
            ]
        }
    ],
    
    xaxis: {
        categories: ['Income', 'Expense', 'Profit'],
        title: {
            text: 'Financial Categories'
        }
    },
    
    yaxis: {
        title: {
            text: 'Amount (Rp)'
        }
    },
    
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            borderRadius: 4,
            dataLabels: {
                position: 'top'
            }
        }
    },
    
    dataLabels: {
        enabled: true,
        formatter: function (val) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
        },
        offsetY: -20,
        style: {
            fontSize: '11px',
            colors: ['#304758']
        }
    },
    
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    
    tooltip: {
        y: {
            formatter: function (val) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
            }
        }
    },
    
    fill: {
        opacity: 1,
        colors: ['#2ecc40', '#065925']
    },
    
    legend: {
        position: 'bottom',
        horizontalAlign: 'middle'
    }
};

var comparisonChart = new ApexCharts(
    document.querySelector("#comparisonChart"),
    comparisonOptions
);

comparisonChart.render();
</script>

@endsection