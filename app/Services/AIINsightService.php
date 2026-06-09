<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AIInsightService
{
    public function generate(array $data)
{
    $prompt = $this->buildPrompt($data);

    $response = Http::post(
        'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' .
        config('services.gemini.api_key'),
        [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $prompt
                        ]
                    ]
                ]
            ]
        ]
    );

    $responseData = $response->json();

    // Jika Gemini error (quota habis, dll)
    if (isset($responseData['error'])) {
        return [
            'revenue_title' => 'AI Tidak Tersedia',
            'revenue' => 'Insight AI sementara tidak tersedia.',
            'profits_title' => 'AI Tidak Tersedia',
            'profits' => 'Insight AI sementara tidak tersedia.',
            'budget_title' => 'AI Tidak Tersedia',
            'budget' => 'Insight AI sementara tidak tersedia.',
            'expenses_title' => 'AI Tidak Tersedia',
            'expenses' => 'Insight AI sementara tidak tersedia.',
            'recommendations' => [
                [
                    'title' => 'AI Offline',
                    'content' => 'Kuota Gemini telah habis.'
                ],
                [
                    'title' => 'Coba Lagi',
                    'content' => 'Tunggu reset kuota atau gunakan API key lain.'
                ]
            ]
        ];
    }

    $text = data_get(
        $responseData,
        'candidates.0.content.parts.0.text',
        '{}'
    );

    $result = json_decode($text, true);

    return $result ?: [
        'revenue_title' => 'Revenue Insight',
        'revenue' => 'Insight AI sementara tidak tersedia.',
        'profits_title' => 'Profits Insight',
        'profits' => 'Insight AI sementara tidak tersedia.',
        'budget_title' => 'Budget Insight',
        'budget' => 'Insight AI sementara tidak tersedia.',
        'expenses_title' => 'Expenses Insight',
        'expenses' => 'Insight AI sementara tidak tersedia.',
        'recommendations' => []
    ];
}
    
    private function buildPrompt(array $data): string
        {
            return "
        You are a professional financial advisor for Aturin, a budget management application.
        Analyze the financial data provided and generate actionable financial insights.

        Financial Data:

        Income: {$data['income']}
        Expense: {$data['expense']}
        Income Growth: {$data['income_growth']}%
        Expense Growth: {$data['expense_growth']}%

        Requirements:

        General Rules:
        All output must be written in English.
        Use a professional and concise tone.
        Base every insight on the provided financial data.
        Do not invent additional metrics or assumptions.
        Do not include explanations outside the JSON response.
        Do not use Markdown.
        Do not wrap the response in code blocks.
        Output must be valid JSON only.

        Insight Sections:
        revenue_title: maximum 3 words
        revenue: maximum 20 words
        profits_title: maximum 3 words
        profits: maximum 20 words
        budget_title: maximum 3 words
        budget: maximum 20 words
        expenses_title: maximum 3 words
        expenses: maximum 20 words

        Strategic Recommendations:

        Generate exactly 2 recommendations.
        recommendation title: maximum 3 words
        recommendation content: maximum 25 words
        Recommendations must be specific, actionable, and based on the insights above.

        Special Considerations:

        If expense growth exceeds income growth, highlight spending risks.
        If income growth exceeds expense growth, highlight positive financial momentum.
        Focus on profitability, spending control, budget sustainability, and growth trends.
        Avoid repeating the same message across multiple sections.

        Format:
        {
        \"revenue_title\": \"...\",
        \"revenue\": \"...\",
        \"profits_title\": \"...\",
        \"profits\": \"...\",
        \"budget_title\": \"...\",
        \"budget\": \"...\",
        \"expenses_title\": \"...\",
        \"expenses\": \"...\",
        \"recommendations\": [
            {
            \"title\": \"...\",
            \"content\": \"...\"
            },
            {
            \"title\": \"...\",
            \"content\": \"...\"
            }
        ]
        }
        ";
    }
}