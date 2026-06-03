@extends('layouts.aturin')

@section('content')

<div class="dashboard-page">
    @include('partials.sidebar')

    <main class="main-content">

        <div class="top-title">
            <h1 class="text-4xl font-bold text-white">Budget</h1>
        </div>

        <div class="action-group">
            <button class="income-btn"> <i class="fa-solid fa-plus mr-2"></i> Add Budget
            </button>
        </div>

        <div class="summary-card budget-overview-card shadow-lg">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-bold text-gray-800">May 2026 Budget</h3>
                <span class="text-xs text-gray-500 font-semibold">67.8% used</span>
            </div>
            
            <div class="grid grid-cols-3 gap-4 my-4">
                <div class="p-3 bg-green-50/60 rounded-xl border border-green-100">
                    <p class="text-xs text-gray-500 font-medium">Total Budget</p>
                    <p class="text-xl font-bold text-green-700 mt-1">Rp 13.000.000</p>
                </div>
                <div class="p-3 bg-red-50/60 rounded-xl border border-red-100">
                    <p class="text-xs text-gray-500 font-medium">Total Spent</p>
                    <p class="text-xl font-bold text-red-700 mt-1">Rp 12.231.420</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                    <p class="text-xs text-gray-500 font-medium">Remaining</p>
                    <p class="text-xl font-bold text-gray-700 mt-1">Rp 4.000.000</p>
                </div>
            </div>

            <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden mt-3">
                <div class="bg-green-500 h-full rounded-full" style="width: 67.8%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-2">20 days remaining in May 2026</p>
        </div>

        <div class="flex flex-col gap-3">
            <div class="budget-alert !border-red-200">
                <div class="alert-side !bg-red-500"></div>
                
                <div class="alert-content !text-red-800 !bg-red-50/50 w-full flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-lg text-red-500"></i>
                    <div>
                        <p class="font-bold text-sm">Over Budget Alert</p>
                        <p class="text-sm mt-0.5">Marketing category is at 95.4% of allocated budget. Immediate action recommended. Approaching Limit</p>
                    </div>
                </div>
            </div>

            <div class="budget-alert">
                <div class="alert-side bg-yellow-400"></div>
                <div class="alert-content flex items-center gap-3 w-full">
                    <i class="fa-solid fa-clock text-lg text-yellow-600"></i>
                    <div>
                        <p class="font-bold text-sm">Approaching Limit</p>
                        <p class="text-sm mt-0.5">Operations spending at 89.5% - monitor closely for the remainder of the month.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="category-budget-card">
            <h3 class="text-lg font-bold mb-5">Budget by Category</h3>
            
            <div class="flex flex-col gap-6">
                <div class="category-item-box">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            <span class="font-bold text-sm">Marketing</span>
                        </div>
                        <button class="text-gray-400 hover:text-black transition"><i class="fa-solid fa-pen text-xs"></i></button>
                    </div>
                    <div class="grid grid-cols-3 gap-3 text-center mb-2">
                        <div class="bg-blue-50 p-2 rounded-lg"><p class="text-[10px] text-blue-600 font-bold uppercase">Allocated</p><p class="text-xs font-bold text-blue-900 mt-0.5">Rp 13.000.000</p></div>
                        <div class="bg-purple-50 p-2 rounded-lg"><p class="text-[10px] text-purple-600 font-bold uppercase">Spent</p><p class="text-xs font-bold text-purple-900 mt-0.5">Rp 12.231.420</p></div>
                        <div class="bg-green-50 p-2 rounded-lg"><p class="text-[10px] text-green-600 font-bold uppercase">Remaining</p><p class="text-xs font-bold text-green-900 mt-0.5">Rp 4.000.000</p></div>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-red-600 h-full" style="width: 95%"></div>
                    </div>
                    <div class="flex justify-between items-center mt-1 text-[11px]">
                        <span class="text-gray-500 font-medium">95% used</span>
                        <span class="text-red-600 font-bold"><i class="fa-solid fa-triangle-exclamation mr-1"></i>Over budget risk</span>
                    </div>
                </div>

                <div class="category-item-box">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span class="font-bold text-sm">Operations</span>
                        </div>
                        <button class="text-gray-400 hover:text-black transition"><i class="fa-solid fa-pen text-xs"></i></button>
                    </div>
                    <div class="grid grid-cols-3 gap-3 text-center mb-2">
                        <div class="bg-blue-50 p-2 rounded-lg"><p class="text-[10px] text-blue-600 font-bold uppercase">Allocated</p><p class="text-xs font-bold text-blue-900 mt-0.5">Rp 13.000.000</p></div>
                        <div class="bg-purple-50 p-2 rounded-lg"><p class="text-[10px] text-purple-600 font-bold uppercase">Spent</p><p class="text-xs font-bold text-purple-900 mt-0.5">Rp 12.231.420</p></div>
                        <div class="bg-green-50 p-2 rounded-lg"><p class="text-[10px] text-green-600 font-bold uppercase">Remaining</p><p class="text-xs font-bold text-green-900 mt-0.5">Rp 4.000.000</p></div>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-blue-600 h-full" style="width: 89%"></div>
                    </div>
                    <div class="flex justify-between items-center mt-1 text-[11px]">
                        <span class="text-gray-500 font-medium">89% used</span>
                        <span class="text-yellow-600 font-bold">On track</span>
                    </div>
                </div>

                <div class="category-item-box">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                            <span class="font-bold text-sm">Technology</span>
                        </div>
                        <button class="text-gray-400 hover:text-black transition"><i class="fa-solid fa-pen text-xs"></i></button>
                    </div>
                    <div class="grid grid-cols-3 gap-3 text-center mb-2">
                        <div class="bg-blue-50 p-2 rounded-lg"><p class="text-[10px] text-blue-600 font-bold uppercase">Allocated</p><p class="text-xs font-bold text-blue-900 mt-0.5">Rp 13.000.000</p></div>
                        <div class="bg-purple-50 p-2 rounded-lg"><p class="text-[10px] text-purple-600 font-bold uppercase">Spent</p><p class="text-xs font-bold text-purple-900 mt-0.5">Rp 12.231.420</p></div>
                        <div class="bg-green-50 p-2 rounded-lg"><p class="text-[10px] text-green-600 font-bold uppercase">Remaining</p><p class="text-xs font-bold text-green-900 mt-0.5">Rp 4.000.000</p></div>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-purple-600 h-full" style="width: 77%"></div>
                    </div>
                    <div class="flex justify-between items-center mt-1 text-[11px]">
                        <span class="text-gray-500 font-medium">77% used</span>
                        <span class="text-yellow-600 font-bold">On track</span>
                    </div>
                </div>

                <div class="category-item-box">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                            <span class="font-bold text-sm">Salaries</span>
                        </div>
                        <button class="text-gray-400 hover:text-black transition"><i class="fa-solid fa-pen text-xs"></i></button>
                    </div>
                    <div class="grid grid-cols-3 gap-3 text-center mb-2">
                        <div class="bg-blue-50 p-2 rounded-lg"><p class="text-[10px] text-blue-600 font-bold uppercase">Allocated</p><p class="text-xs font-bold text-blue-900 mt-0.5">Rp 13.000.000</p></div>
                        <div class="bg-purple-50 p-2 rounded-lg"><p class="text-[10px] text-purple-600 font-bold uppercase">Spent</p><p class="text-xs font-bold text-purple-900 mt-0.5">Rp 12.231.420</p></div>
                        <div class="bg-green-50 p-2 rounded-lg"><p class="text-[10px] text-green-600 font-bold uppercase">Remaining</p><p class="text-xs font-bold text-green-900 mt-0.5">Rp 4.000.000</p></div>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-yellow-500 h-full" style="width: 30%"></div>
                    </div>
                    <div class="flex justify-between items-center mt-1 text-[11px]">
                        <span class="text-gray-500 font-medium">30% used</span>
                        <span class="text-green-600 font-bold">Well under budget</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="history-section">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-green-500"></i> Budget Performance History
            </h3>
            <div class="history-placeholder flex items-center justify-center text-gray-400">
                <i class="fa-solid fa-chart-area text-5xl opacity-20"></i>
            </div>
        </div>

    </main>
</div>

@endsection