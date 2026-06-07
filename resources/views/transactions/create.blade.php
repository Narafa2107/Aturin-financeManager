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

        <form action="{{ route('transactions.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="table-card">

            @csrf

            <div class="flex flex-col gap-4">

                <select
                    name="type"
                    id="transaction-type"
                    class="filter-select">
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>

                <input
                    type="text"
                    name="description"
                    placeholder="Description"
                    class="date-input"
                >

                <div id="category-wrapper">
                    <select
                        name="category"
                        id="category"
                        class="filter-select w-full">

                        <option value="">Select Category</option>
                        <option value="marketing">Marketing</option>
                        <option value="operations">Operations</option>
                        <option value="technology">Technology</option>
                        <option value="salary">Salary</option>
                    </select>
                </div>

                <input
                    type="number"
                    name="amount"
                    placeholder="Amount"
                    class="date-input"
                >

                <input
                    type="date"
                    name="transaction_date"
                    class="date-input"
                >

                <input
                    type="file"
                    name="receipt"
                    class="date-input"
                >

                <div class="action-group">
                    <button type="submit" class="income-btn">
                        Save Transaction
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