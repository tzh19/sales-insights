<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Sale;

class AiInsightController extends Controller
{
    public function generate()
    {
        $sale = new Sale();

        $summaryData = $sale->summary();

        $prompt = "Summarize the following sales data in one sentence. ".
                  "Use only the given information and do not add anything new.\n\n".
                  json_encode($summaryData);

        $response = Http::post('http://localhost:11434/api/generate', [
          'model' => 'mistral',
          'prompt' => $prompt,
          'stream' => false
                ]);

        $result = $response->json();
        return response()->json([
            'insight' => $result['response'] ?? 'No insight generated.',
        ]);
    }
}
