<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/publications', [\App\Http\Controllers\V1\UserPublicationsController::class, 'index']);
    Route::post('/user/publications', [\App\Http\Controllers\V1\UserPublicationsController::class, 'store']);

    Route::get('/publications', [\App\Http\Controllers\V1\PublicationController::class, 'index']);
    Route::get('/publications/{publication}', [\App\Http\Controllers\V1\PublicationController::class, 'show']);
    Route::put('/publications/{publication}', [\App\Http\Controllers\V1\PublicationController::class, 'update']);
    Route::delete('/publications/{publication}', [\App\Http\Controllers\V1\PublicationController::class, 'destroy']);
    Route::get('publications/{publication}/authors', [\App\Http\Controllers\V1\PublicationAuthorsController::class, 'index']);
    Route::post('publications/{publication}/authors', [\App\Http\Controllers\V1\PublicationAuthorsController::class, 'store']);
});

// /login
// /register
// /logout

// /v1/user/publications |GET|POST|
// /v1/user/publications/:id |GET|PUT|DELETE|
// /v1/user/publications/:id/upload |POST|
// /v1/user/publications/:id/download |GET|
// /v1/user/publications/:id/participants |GET|POST|
// /v1/user/publications/:id/authors |GET|POST|

// /v1/user/books |GET|POST|
// /v1/user/books /:id |GET|PUT|DELETE|
// /v1/user/books /:id/upload |POST|
// /v1/user/books /:id/download |GET|

// /v1/user/courses |GET|POST|
// /v1/user/courses/:id |GET|PUT|DELETE|
// /v1/user/courses/:id/upload |POST|
// /v1/user/courses/:id/download |GET|
