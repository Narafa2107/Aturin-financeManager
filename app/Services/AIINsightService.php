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
        Anda adalah financial advisor untuk aplikasi Aturin.

        Analisis data keuangan berikut dan hasilkan response dalam format JSON VALID.

        Data:
        Income: {$data['income']}
        Expense: {$data['expense']}
        Income Growth: {$data['income_growth']}%
        Expense Growth: {$data['expense_growth']}%

        Aturan:
        - revenue maksimal 20 kata
        - profits maksimal 20 kata
        - budget maksimal 20 kata
        - expenses maksimal 20 kata
        - revenue_title maksimal 3 kata
        - profits_title maksimal 3 kata
        - budget_title maksimal 3 kata
        - expenses_title maksimal 3 kata
        - berikan tepat 2 strategic recommendations
        - recommendation title maksimal 3 kata
        - recommendation content maksimal 25 kata
        - gunakan bahasa Indonesia profesional
        - jangan gunakan markdown
        - output HARUS berupa JSON valid

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