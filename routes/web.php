<?php

use App\Http\Controllers\Web\ActorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('actors.index');
});

Route::resource('/actors', ActorController::class)->only(['index', 'create', 'store']);
