<?php

namespace App\Integrations\OpenAI;

use Illuminate\Support\Facades\Http;

class OpenAIClient implements OpenAIClientInterface
{
    public function getPrompt(): string
    {
        return "Today is " . now()->toDateString() .
            ". Please extract first name, last name, address, height, weight, gender, and age from the actor description.";
    }

    public function extractActorData(string $description): array
    {
        $prompt = $this->getPrompt();

        $response = Http::withToken(config('services.openai.key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model'    => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => $prompt],
                    ['role' => 'user', 'content' => $description],
                ],
            ]);

        $content = $response->json('choices.0.message.content');

        if (!$content) {
            return [];
        }

        $data = json_decode($content, true);

        if (!is_array($data)) {
            return [];
        }

        return $data;
    }

}
