<?php

namespace App\Integrations\OpenAI;

interface OpenAIClientInterface
{
    public function extractActorData(string $description): array;

    public function getPrompt() : string;
}
