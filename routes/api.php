<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('questions', App\Http\Controllers\QuestionController::class);
    Route::delete('/questions/{question}/archive', [App\Http\Controllers\QuestionController::class, 'archive'])
        ->name('questions.archive');
    Route::put('/questions/{question}/archive', [App\Http\Controllers\QuestionController::class, 'restore'])
        ->name('questions.restore');
    Route::put('questions/{question}/publish', [\App\Http\Controllers\QuestionController::class, 'publish'])
        ->name('questions.publish');
});
