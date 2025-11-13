<?php

namespace Tests\Unit;

use App\Integrations\OpenAI\OpenAIClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;


class OpenAIClientTest extends TestCase
{
    protected OpenAIClient $client;

    protected function setUp(): void
    {
        parent::setUp();

        // Створюємо реальний клієнт, а не той, що підміняється у ServiceProvider
        $this->client = new OpenAIClient();
    }

     #[Test]
    public function it_returns_prompt_with_today_date()
    {
        $today = now()->toDateString();
        $prompt = $this->client->getPrompt();

        $this->assertStringContainsString("Today is {$today}", $prompt);
        $this->assertStringContainsString('Please extract', $prompt);
    }

     #[Test]
    public function it_returns_parsed_array_when_openai_returns_valid_json()
    {
        Http::fake([
                       'https://api.openai.com/v1/chat/completions' => Http::response(
                           [
                               'choices' => [
                                   [
                                       'message' => [
                                           'content' => json_encode(
                                               [
                                                   'name' => 'John',
                                                   'surname' => 'Doe',
                                                   'address' => '123 Main St',
                                               ]),
                                       ],
                                   ],
                               ],
                           ], 200),
                   ]);

        $result = $this->client->extractActorData('Actor description');

        $this->assertIsArray($result);
        $this->assertEquals('John', $result['name']);
        $this->assertEquals('Doe', $result['surname']);
        $this->assertEquals('123 Main St', $result['address']);
    }

     #[Test]
    public function it_returns_error_array_when_openai_fails()
    {
        Http::fake([
                       'https://api.openai.com/v1/chat/completions' => Http::response('Quota exceeded', 429),
                   ]);

        Log::shouldReceive('error')->once();

        $result = $this->client->extractActorData('Some description');

        $this->assertArrayHasKey('__error', $result);
        $this->assertEquals('OpenAI service unavailable', $result['__error']);
    }

     #[Test]
    public function it_returns_error_array_when_openai_returns_invalid_json()
    {
        Http::fake([
                       'https://api.openai.com/v1/chat/completions' => Http::response(
                           [
                               'choices' => [
                                   [
                                       'message' => [
                                           'content' => 'not a json',
                                       ],
                                   ],
                               ],
                           ]),
                   ]);

        Log::shouldReceive('warning')->once();
        Log::shouldReceive('error')->once();

        $result = $this->client->extractActorData('Invalid data test');

        $this->assertArrayHasKey('__error', $result);
        $this->assertEquals('OpenAI service unavailable', $result['__error']);
    }
}
