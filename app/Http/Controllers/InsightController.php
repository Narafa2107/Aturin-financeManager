<?php

namespace App\Http\Controllers;

use App\Services\AIInsightService;

class InsightController extends Controller
{
    public function index(AIInsightService $ai)
    {
        $data = [
            'income' => 5000000,
            'expense' => 4500000,
            'income_growth' => 10,
            'expense_growth' => 25,
        ];

        $insight = $ai->generate($data);

        return view('insights.insights', ['AIinsights' => $insight]);
    }
}