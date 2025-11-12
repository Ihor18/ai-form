<?php

namespace App\Domain\Actors\Contracts;

interface ActorServiceInterface
{
    public function getAll();

    public function createActor(array $data): array;
}
