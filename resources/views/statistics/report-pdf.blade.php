<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Financial Report</title>

    <style>
        .header{
            text-align:center;
            margin-bottom:30px;
        }

        .header img{
            width:80px;
            margin-bottom:10px;
        }
        body{
            font-family: sans-serif;
        }

        table{
            width:100%;
            border-collapse: collapse;
        }

        th,td{
            border:1px solid #000;
            padding:8px;
        }

        h1{
            text-align:center;
        }
    </style>
</head>
<body>
<div class="header">
    <img src="{{ public_path('asset/logo 2.png') }}">
    <h1>ATURIN FINANCIAL REPORT</h1>
</div>

<h1>Financial Report</h1>

<p>
    <strong>Total Income:</strong>
    Rp {{ number_format($totalIncome,0,',','.') }}
</p>

<p>
    <strong>Total Expense:</strong>
    Rp {{ number_format($totalExpense,0,',','.') }}
</p>

<p>
    <strong>Net Profit:</strong>
    Rp {{ number_format($netProfit,0,',','.') }}
</p>

<hr>

<h3>Transaction Details</h3>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Description</th>
            <th>Category</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody>
        @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->transaction_date }}</td>
            <td>{{ ucfirst($transaction->type) }}</td>
            <td>{{ $transaction->description }}</td>
            <td>{{ $transaction->category }}</td>
            <td>
                Rp {{ number_format($transaction->amount,0,',','.') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>