@extends('layouts.aturin')

@section('content')

<div class="dashboard-page">
    @include('partials.sidebar')

    <main class="main-content">

        <div class="top-title">
            <h1 class="text-4xl font-bold text-white">Budget Management</h1>
        </div>

        <div class="action-group flex flex-wrap gap-3 mb-6">
            <button id="openAllocateBtn" class="income-btn !bg-blue-600 hover:!bg-blue-500 text-white" onclick="toggleModal('allocateModal', true)"> 
                <i class="fa-solid fa-pie-chart mr-2"></i> Allocate Budget
            </button>

            <button id="openSourceBtn" class="income-btn !bg-green-600 hover:!bg-green-500 text-white" onclick="toggleModal('sourceModal', true)"> 
                <i class="fa-solid fa-wallet mr-2"></i> Add New Budget Source
            </button>
        </div>

        <div id="allocateModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center p-4 backdrop-blur-sm">
            <div class="bg-gray-800 border border-gray-700 rounded-2xl w-full max-w-md p-6 shadow-2xl text-left">
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-700">
                    <h3 class="text-xl font-bold text-white">Allocate Budget to Category</h3>
                    <button onclick="toggleModal('allocateModal', false)" class="text-gray-400 hover:text-white transition text-lg">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form action="{{ route('budget.store') }}" method="POST">
                    @csrf 
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Category</label>
                        <select name="category_name" required class="w-full bg-gray-950 border border-gray-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-blue-500">
                            <option value="" disabled selected>Select Category</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Operations">Operations</option>
                            <option value="Technology">Technology</option>
                            <option value="Salary">Salary</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Amount to Allocate (Rp)</label>
                        <input type="number" name="allocated_amount" min="1000" required placeholder="e.g. 5000000"
                            class="w-full bg-gray-950 border border-gray-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-blue-500">
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="toggleModal('allocateModal', false)" class="px-4 py-2 bg-gray-700 text-white rounded-xl hover:bg-gray-600 transition text-sm font-semibold">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-500 transition text-sm font-semibold shadow-lg shadow-blue-900/30">Save Allocation</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="sourceModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center p-4 backdrop-blur-sm">
            <div class="bg-gray-800 border border-gray-700 rounded-2xl w-full max-w-md p-6 shadow-2xl text-left">
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-700">
                    <h3 class="text-xl font-bold text-white">Add Budget Source / Capital</h3>
                    <button onclick="toggleModal('sourceModal', false)" class="text-gray-400 hover:text-white transition text-lg">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form action="{{ route('budget.storeSource') }}" method="POST">
                    @csrf 
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Source Type</label>
                        <select name="source_name" required class="w-full bg-gray-950 border border-gray-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-green-500">
                            <option value="" disabled selected>Select Source</option>
                            <option value="Asset">Asset / Modal Sendiri</option>
                            <option value="Loan">Pinjaman / Hutang</option>
                            <option value="Other">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Amount (Rp)</label>
                        <input type="number" name="amount" min="1000" required placeholder="e.g. 50000000"
                            class="w-full bg-gray-950 border border-gray-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-green-500">
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="toggleModal('sourceModal', false)" class="px-4 py-2 bg-gray-700 text-white rounded-xl hover:bg-gray-600 transition text-sm font-semibold">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-500 transition text-sm font-semibold shadow-lg shadow-green-900/30">Add Source</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 my-4">
            <div class="p-4 bg-gray-800 rounded-xl border border-gray-700 shadow-md">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Total Assets</p>
                <p class="text-xl font-bold text-white mt-1">Rp {{ number_format($totalAssets, 0, ',', '.') }}</p>
                <p class="text-[10px] text-gray-500 mt-1">Capital + Profit (Real Cash)</p>
            </div>
            
            <div class="p-4 bg-gray-800 rounded-xl border border-gray-700 shadow-md">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Unallocated Funds</p>
                <p class="text-xl font-bold text-amber-500 mt-1">Rp {{ number_format($unallocatedFunds, 0, ',', '.') }}</p>
                <p class="text-[10px] text-gray-500 mt-1">Available to allocate to category</p>
            </div>

            <div class="p-4 bg-gray-800 rounded-xl border border-gray-700 shadow-md">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Total Allocated</p>
                <p class="text-xl font-bold text-blue-500 mt-1">Rp {{ number_format($totalAllocated, 0, ',', '.') }}</p>
                <p class="text-[10px] text-gray-500 mt-1">Total division budget allocation</p>
            </div>
            
            <div class="p-4 bg-gray-800 rounded-xl border border-gray-700 shadow-md">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Total Remaining Budget</p>
                <p class="text-xl font-bold text-green-500 mt-1">Rp {{ number_format($totalRemaining, 0, ',', '.') }}</p>
                <p class="text-[10px] text-gray-500 mt-1">Total Allocated - Total Expense</p>
            </div>
        </div>

        @if($criticalBudget)
            <div class="flex flex-col gap-3 my-4">
                
                {{-- JIKA SUDAH DI ATAS ATAU SAMA DENGAN 90% (ZONA MERAH) --}}
                @if($criticalBudget->percentage_used >= 90)
                    <div class="budget-alert !border-red-200">
                        <div class="alert-side !bg-red-500"></div>
                        <div class="alert-content !text-red-800 !bg-red-50/50 w-full flex items-center gap-3">
                            <i class="fa-solid fa-circle-exclamation text-lg text-red-500"></i>
                            <div>
                                <p class="font-bold text-sm">Over Budget Alert</p>
                                <p class="text-sm mt-0.5">The <strong>{{ $criticalBudget->category_name }}</strong> category has used <strong>{{ number_format($criticalBudget->percentage_used, 1) }}%</strong> of its allocated budget. Immediate action recommended!</p>
                            </div>
                        </div>
                    </div>
                
                {{-- JIKA DI ANTARA 70% - 89.9% (ZONA KUNING WARNING) --}}
                @else
                    <div class="budget-alert !border-yellow-200">
                        <div class="alert-side !bg-yellow-500"></div>
                        <div class="alert-content !text-yellow-800 !bg-yellow-50/50 w-full flex items-center gap-3">
                            <i class="fa-solid fa-triangle-exclamation text-lg text-yellow-600"></i>
                            <div>
                                <p class="font-bold text-sm">Approaching Budget Limit</p>
                                <p class="text-sm mt-0.5">The <strong>{{ $criticalBudget->category_name }}</strong> category spending is at <strong>{{ number_format($criticalBudget->percentage_used, 1) }}%</strong>. Please monitor closely.</p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        @endif

        <div class="category-budget-card">
            <h3 class="text-lg font-bold mb-5">Budget by Category</h3>
            
            <div class="flex flex-col gap-6">
                @forelse($budgets as $budget)
                    <div class="category-item-box">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-2">
                                @if($budget->category_name == 'Marketing')
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                @elseif($budget->category_name == 'Operations')
                                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                @elseif($budget->category_name == 'Technology')
                                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                                @else
                                    <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                @endif
                                
                                <span class="font-bold text-sm">{{ $budget->category_name }}</span>
                            </div>

                            <form action="{{ route('budget.destroy', $budget->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this budget allocation?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition duration-150">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                            
                        </div>

                        <div class="grid grid-cols-3 gap-3 text-center mb-2">
                            <div class="bg-blue-50 p-2 rounded-lg">
                                <p class="text-[10px] text-blue-600 font-bold uppercase">Allocated</p>
                                <p class="text-xs font-bold text-blue-900 mt-0.5">Rp {{ number_format($budget->allocated_amount, 0, ',', '.') }}</p>
                            </div>
                            
                            <div class="bg-purple-50 p-2 rounded-lg">
                                <p class="text-[10px] text-purple-600 font-bold uppercase">Spent</p>
                                <p class="text-xs font-bold text-purple-900 mt-0.5">Rp {{ number_format($budget->spent, 0, ',', '.') }}</p>
                            </div>
                            
                            <div class="bg-green-50 p-2 rounded-lg">
                                <p class="text-[10px] text-green-600 font-bold uppercase">Remaining</p>
                                <p class="text-xs font-bold text-green-900 mt-0.5">Rp {{ number_format($budget->remaining, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-600 h-full" style="width: {{ $budget->percentage_used }}%"></div>
                        </div>

                        <div class="flex justify-between items-center mt-1 text-[11px]">
                            <span class="text-gray-500 font-medium">{{ number_format($budget->percentage_used, 1) }}% used</span>
                            
                            @if($budget->percentage_used >= 90)
                                <span class="text-red-600 font-bold"><i class="fa-solid fa-triangle-exclamation mr-1"></i>Over budget risk</span>
                            @else
                                <span class="text-green-600 font-bold">On track</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 bg-gray-800 text-center rounded-xl text-gray-400 border border-dashed border-gray-700">
                        <i class="fa-solid fa-folder-open text-3xl opacity-30 mb-2"></i>
                        <p class="text-sm">No budget categories allocated yet. Please click "Allocate Budget".</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</div>

<script>
    function toggleModal(modalId, show) {
        const modal = document.getElementById(modalId);
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }
</script>

@endsection