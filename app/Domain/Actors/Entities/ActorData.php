<?php

namespace App\Domain\Actors\Entities;

readonly final class ActorData
{
    public function __construct(
        public string  $name,
        public string  $surname,
        public string  $address,
        public ?float  $height = null,
        public ?float  $weight = null,
        public ?string $gender = null,
        public ?int    $age = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name:    $data['name'] ?? '',
            surname: $data['surname'] ?? '',
            address: $data['address'] ?? '',
            height:  isset($data['height']) ? (float)$data['height'] : null,
            weight:  isset($data['weight']) ? (float)$data['weight'] : null,
            gender:  $data['gender'] ?? null,
            age:     isset($data['age']) ? (int)$data['age'] : null,
        );
    }


    public function toArray(): array
    {
        return [
            'name'    => $this->name,
            'surname' => $this->surname,
            'address' => $this->address,
            'height'  => $this->height,
            'weight'  => $this->weight,
            'gender'  => $this->gender,
            'age'     => $this->age,
        ];
    }
}
