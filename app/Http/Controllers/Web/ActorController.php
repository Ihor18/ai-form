<?php

namespace App\Http\Controllers\Web;

use App\Domain\Actors\Contracts\ActorServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActorRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ActorController extends Controller
{
    public function __construct(private ActorServiceInterface $actorService) {}

    public function index(): View
    {
        $actors = $this->actorService->getAll();
        return view('actors.index', compact('actors'));
    }

    public function create(): View
    {
        return view('actors.create');
    }

    public function store(StoreActorRequest $request): JsonResponse
    {
        $result = $this->actorService->createActor($request->validated());

        if (!$result['success']) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $result['message']
                ], 422);
        }

        return response()->json(
            [
                'success'  => true,
                'redirect' => route('actors.index')
            ]);
    }
}
