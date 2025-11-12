<?php

namespace App\Integrations\OpenAI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIClient implements OpenAIClientInterface
{
    public function getPrompt(): string
    {
        return "Today is " . now()->toDateString() .
            ". Please extract first name, last name, address, height, weight, gender, and age from the actor description.";
    }

    public function extractActorData(string $description): array
    {
        try {
            $response = Http::withToken(config('services.openai.key'))
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model'    => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => $this->getPrompt()],
                        ['role' => 'user', 'content' => $description],
                    ],
                ]);

            if ($response->failed()) {
                Log::error('OpenAI API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                throw new \RuntimeException('OpenAI API error: ' . $response->body());
            }

            $content = $response->json('choices.0.message.content');
            $data = json_decode($content, true);

            if (!is_array($data)) {
                Log::warning('OpenAI returned invalid JSON', ['content' => $content]);
                throw new \RuntimeException('Invalid JSON from OpenAI');
            }

            return $data;
        } catch (\Throwable $e) {
            Log::error('OpenAI request failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Fallback — не кидаємо exception далі, а повертаємо спеціальний сигнал
            return [
                '__error' => 'OpenAI service unavailable',
                '__message' => $e->getMessage(),
            ];
        }
    }

}
