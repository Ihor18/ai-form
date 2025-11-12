<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Integrations\OpenAI\OpenAIClientInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActorController extends Controller
{

    public function __construct(public OpenAIClientInterface $client) {}

    /**
     * Returns text prompt for OpenAI
     */

    public function promptValidation(): JsonResponse
    {
        $textPrompt = $this->client->getPrompt();

        return response()->json(
            [
                'message' => $textPrompt
            ]);
    }
}
