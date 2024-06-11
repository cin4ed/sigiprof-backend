<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/publications', [
        \App\Http\Controllers\V1\UserPublicationsController::class,
        'index',
    ]);
});
