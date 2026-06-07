@extends('layouts.aturin')

@section('content')

<div class="dashboard-page">

    @include('partials.sidebar')

    <main class="main-content">

        <div class="top-title">
            <h1 class="text-4xl font-bold">
                Add Transaction
            </h1>
        </div>

        <form action="{{ route('transactions.update', $transaction->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="table-card">

            @csrf
            @method('PUT')
            <div class="flex flex-col gap-4">

                <select
                    name="type"
                    id="transaction-type"
                    class="filter-select">

                    <option value="income"
                        {{ $transaction->type == 'income' ? 'selected' : '' }}>
                        Income
                    </option>

                    <option value="expense"
                        {{ $transaction->type == 'expense' ? 'selected' : '' }}>
                        Expense
                    </option>

                </select>

                <input
                    type="text"
                    name="description"
                    value="{{ $transaction->description }}"
                    class="date-input"
                >

                <div id="category-wrapper">
                    <select
                        name="category"
                        id="category"
                        class="filter-select w-full">

                        <option value="">Select Category</option>

                        <option value="marketing"
                            {{ $transaction->category == 'marketing' ? 'selected' : '' }}>
                            Marketing
                        </option>

                        <option value="operations"
                            {{ $transaction->category == 'operations' ? 'selected' : '' }}>
                            Operations
                        </option>

                        <option value="technology"
                            {{ $transaction->category == 'technology' ? 'selected' : '' }}>
                            Technology
                        </option>

                        <option value="salary"
                            {{ $transaction->category == 'salary' ? 'selected' : '' }}>
                            Salary
                        </option>

                    </select>
                </div>

                <input
                    type="number"
                    name="amount"
                    value="{{ $transaction->amount }}"
                    class="date-input"
                >

                <input
                    type="date"
                    name="transaction_date"
                    value="{{ $transaction->transaction_date }}"
                    class="date-input"
                >

                <input
                    type="file"
                    name="receipt"
                    class="date-input"
                >

                <div class="action-group">
                    <button type="submit" class="income-btn">
                        Update Transaction
                    </button>

                    <a href="{{ route('transactions.index') }}"
                       class="export-btn">
                        Cancel
                    </a>
                </div>

            </div>

        </form>

    </main>

</div>
<script>

document.addEventListener('DOMContentLoaded', function () {

    const typeSelect = document.getElementById('transaction-type');
    const categoryWrapper = document.getElementById('category-wrapper');

    function toggleCategory() {

        if (typeSelect.value === 'income') {
            categoryWrapper.style.display = 'none';
        } else {
            categoryWrapper.style.display = 'block';
        }
    }

    toggleCategory();

    typeSelect.addEventListener('change', toggleCategory);

});

</script>
@endsection