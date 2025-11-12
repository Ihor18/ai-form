<?php

namespace App\Providers;

use App\Domain\Actors\Contracts\ActorServiceInterface;
use App\Domain\Actors\Services\ActorService;
use App\Integrations\OpenAI\FakeOpenAIClient;
use App\Integrations\OpenAI\OpenAIClientInterface;
use App\Integrations\OpenAI\OpenAIClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(OpenAIClientInterface::class, function ($app) {
            if ($app->environment('local', 'testing')) {
                return new FakeOpenAIClient();
            }

            return new OpenAIClient();
        });

        $this->app->bind(ActorServiceInterface::class, ActorService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
