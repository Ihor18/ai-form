<?php

namespace App\Integrations\OpenAI;

class FakeOpenAIClient implements OpenAIClientInterface
{
    public function getPrompt(): string
    {
        return (new OpenAIClient())->getPrompt();
    }

    public function extractActorData(string $description): array
    {
        return [
            'name' => 'Test',
            'surname'  => 'Actor',
            'address'    => 'Fake Street 123',
            'height'     => 180,
            'weight'     => 75,
            'gender'     => 'Male',
            'age'        => 30,
        ];
    }
}
