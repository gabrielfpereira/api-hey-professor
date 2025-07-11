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

    Route::post('/votes/{question}/like', [App\Http\Controllers\VoteController::class, 'store'])
        ->name('votes.like');
    Route::post('/votes/{question}/unlike', [App\Http\Controllers\VoteController::class, 'store'])
        ->name('votes.unlike');
});

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])
        ->name('register');
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])
        ->name('login');
    Route::post('logout', [App\Http\Controllers\Auth\LogoutController::class, 'logout'])
        ->name('logout')
        ->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->get('/dashboard', function () {
    //dd(auth()->guard('sanctum')->user(), auth()->user());
    return response()->json(['message' => 'Área protegida']);
});
