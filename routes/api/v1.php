<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get(     '/user/publications', [\App\Http\Controllers\V1\UserPublicationsController::class, 'index']);
    Route::post(    '/user/publications', [\App\Http\Controllers\V1\UserPublicationsController::class, 'store']);

    Route::get(     '/publications', [\App\Http\Controllers\V1\PublicationController::class, 'index']);
    Route::get(     '/publications/{publication}', [\App\Http\Controllers\V1\PublicationController::class, 'show']);
    Route::put(     '/publications/{publication}', [\App\Http\Controllers\V1\PublicationController::class, 'update']);
    Route::delete(  '/publications/{publication}', [\App\Http\Controllers\V1\PublicationController::class, 'destroy']);
    
    Route::get(     '/publications/{publication}/authors', [\App\Http\Controllers\V1\PublicationAuthorsController::class, 'index']);
    Route::post(    '/publications/{publication}/authors', [\App\Http\Controllers\V1\PublicationAuthorsController::class, 'store']);

    Route::get(     '/user/books', [\App\Http\Controllers\V1\UserBooksController::class, 'index']);
    Route::post(    '/user/books', [\App\Http\Controllers\V1\UserBooksController::class, 'store']);
});
