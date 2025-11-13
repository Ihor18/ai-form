<?php

namespace Tests\Unit;

use App\Domain\Actors\Services\ActorService;
use App\Integrations\OpenAI\OpenAIClientInterface;
use App\Models\Actor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;


class ActorServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_actor_when_valid_data_returned_from_openai()
    {
        $mockOpenAI = Mockery::mock(OpenAIClientInterface::class);
        $mockOpenAI->shouldReceive('extractActorData')
            ->once()
            ->andReturn([
                            'name' => 'John',
                            'surname' => 'Doe',
                            'address' => '123 Street',
                            'height' => '180',
                            'weight' => '75',
                            'gender' => 'male',
                            'age' => 30,
                        ]);

        $service = new ActorService($mockOpenAI);

        $data = [
            'email' => 'john@example.com',
            'description' => 'An actor description'
        ];

        $result = $service->createActor($data);

        $this->assertTrue($result['success']);
        $this->assertDatabaseHas('actors', [
            'email' => 'john@example.com',
            'name' => 'John',
            'surname' => 'Doe'
        ]);
    }

    #[Test]
    public function it_returns_error_when_required_fields_missing()
    {
        $mockOpenAI = Mockery::mock(OpenAIClientInterface::class);
        $mockOpenAI->shouldReceive('extractActorData')
            ->once()
            ->andReturn([
                            'name' => null,
                            'surname' => null,
                            'address' => null,
                        ]);

        $service = new ActorService($mockOpenAI);

        $data = [
            'email' => 'missing@example.com',
            'description' => 'Incomplete data'
        ];

        $result = $service->createActor($data);

        $this->assertFalse($result['success']);
        $this->assertEquals(
            'Please add first name, last name, and address to your description.',
            $result['message']
        );

        $this->assertDatabaseMissing('actors', ['email' => 'missing@example.com']);
    }

    #[Test]
    public function it_returns_all_actors()
    {
        Actor::factory()->create(['email' => 'actor1@example.com']);
        Actor::factory()->create(['email' => 'actor2@example.com']);

        $mockOpenAI = Mockery::mock(OpenAIClientInterface::class);
        $service = new ActorService($mockOpenAI);

        $actors = $service->getAll()->sortBy('email')->values();

        $this->assertCount(2, $actors);
        $this->assertEquals('actor1@example.com', $actors->first()->email);
    }
}
