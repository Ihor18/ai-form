<?php

namespace Tests\Feature;


use App\Integrations\OpenAI\FakeOpenAIClient;
use App\Integrations\OpenAI\OpenAIClientInterface;
use App\Models\Actor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ActorControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $mockOpenAI = Mockery::mock(OpenAIClientInterface::class);
        $mockOpenAI->shouldReceive('extractActorData')
            ->andReturn([
                            'name'    => 'John',
                            'surname' => 'Doe',
                            'address' => '123 Test St',
                            'height'  => 180,
                            'weight'  => 75,
                            'gender'  => 'Male',
                            'age'     => 35,
                        ]);

        $this->app->instance(OpenAIClientInterface::class, $mockOpenAI);
    }

     #[Test]
    public function it_shows_index_page()
    {
        Actor::factory()->create(
            [
                'name' => 'Tom',
                'address'    => 'New York',
            ]);

        $response = $this->get('/actors');

        $response->assertStatus(200);
        $response->assertSee('Tom');
    }

     #[Test]
    public function it_shows_create_page()
    {
        $response = $this->get('/actors/create');
        $response->assertStatus(200);
        $response->assertSee('Actor Description');
    }

     #[Test]
    public function it_stores_actor_successfully()
    {
        $this->withoutMiddleware();

        $response = $this->postJson('/actors', [
            'email'       => 'test@example.com',
            'description' => 'John Doe lives at 123 Test St and is 35 years old male height 180 weight 75',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['redirect']);

        $this->assertDatabaseHas('actors', [
            'email'      => 'test@example.com',
            'name' => 'John',
            'surname'  => 'Doe',
            'address'    => '123 Test St',
        ]);
    }

     #[Test]
    public function it_returns_validation_error_if_description_is_incomplete()
    {
        $this->withoutMiddleware();
        $mockOpenAI = Mockery::mock(OpenAIClientInterface::class);
        $mockOpenAI->shouldReceive('extractActorData')
            ->andReturn([
                            'name'    => null,
                            'surname' => null,
                            'address' => null,
                        ]);
        $this->app->instance(OpenAIClientInterface::class, $mockOpenAI);

        $response = $this->postJson('/actors', [
            'email'       => 'fail@example.com',
            'description' => 'Just some random text',
        ]);

        $response->assertStatus(422)
            ->assertJson(
                [
                    'success' => false,
                    'message' => 'Please add first name, last name, and address to your description.'
                ]);
    }

     #[Test]
    public function it_returns_prompt_validation_from_api()
    {
        $this->app->bind(OpenAIClientInterface::class, FakeOpenAIClient::class);

        $response = $this->getJson("api/actors/prompt-validation");

        $response->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertStringContainsString(
            now()->toDateString(),
            $response->json('message')
        );
    }
}
