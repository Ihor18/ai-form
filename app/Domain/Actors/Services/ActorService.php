<?php

namespace App\Domain\Actors\Services;

use App\Domain\Actors\Contracts\ActorServiceInterface;
use App\Domain\Actors\Entities\ActorData;
use App\Integrations\OpenAI\OpenAIClientInterface;
use App\Models\Actor;

class ActorService implements ActorServiceInterface
{
    public function __construct(private OpenAIClientInterface $openAI) {}

    public function getAll()
    {
        return Actor::latest()->get();
    }

    public function createActor(array $data): array
    {
        $parsed = $this->openAI->extractActorData($data['description']);

        $actorDTO = ActorData::fromArray($parsed);

        if (!$actorDTO->firstName || !$actorDTO->lastName || !$actorDTO->address) {
            return [
                'success' => false,
                'message' => 'Please add first name, last name, and address to your description.'
            ];
        }

        Actor::create(array_merge($data, $actorDTO->toArray()));

        return ['success' => true];
    }
}
