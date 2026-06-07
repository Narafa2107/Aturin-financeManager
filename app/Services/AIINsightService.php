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

        $text = $response['candidates'][0]['content']['parts'][0]['text'] ?? '{}';

        return json_decode($text, true);
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
        - berikan tepat 2 strategic recommendations
        - recommendation title maksimal 6 kata
        - recommendation content maksimal 25 kata
        - gunakan bahasa Indonesia profesional
        - jangan gunakan markdown
        - output HARUS berupa JSON valid

        Format:

        {
        \"revenue\": \"...\",
        \"profits\": \"...\",
        \"budget\": \"...\",
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