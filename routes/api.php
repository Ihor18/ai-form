<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ActorController;

Route::get('/actors/prompt-validation', [ActorController::class, 'promptValidation']);
