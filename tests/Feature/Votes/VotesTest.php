<?php

use App\Models\{Question, User, Vote};
use Laravel\Sanctum\Sanctum;

test("o usuario deve ser autenticado para votar", function () {
    $this->postJson(route('votes.like', 1))
        ->assertUnauthorized();
});

test("o usuario deve votar apenas uma vez", function () {
    $user      = User::factory()->create();
    $otherUser = User::factory()->create();
    $question  = Question::factory()->create();
    Vote::factory()->create([
        'user_id'     => $user->id,
        'question_id' => $question->id,
    ]);

    Sanctum::actingAs($user);
    $this->postJson(route('votes.like', $question), [
        'type' => 'like',
    ])
        ->assertForbidden();

    Sanctum::actingAs($otherUser);
    $this->postJson(route('votes.like', $question), [
        'type' => 'like',
    ])
        ->assertCreated();
});

test("o usuario não pode votar em sua própria pergunta", function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create([
        'user_id' => $user->id,
    ]);

    Sanctum::actingAs($user);
    $this->postJson(route('votes.like', $question), [
        'type' => 'like',
    ])
        ->assertForbidden();
});

test("o usuario deve conseguir votar", function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create();

    Sanctum::actingAs($user);
    $this->postJson(route('votes.like', $question), [
        'type' => 'like',
    ])
        ->assertCreated();
});

test("o usuario deve conserguir dar like e unlike apenas", function ($type, $code) {
    $user     = User::factory()->create();
    $question = Question::factory()->create();

    Sanctum::actingAs($user);
    $this->postJson(route('votes.unlike', $question), [
        'type' => $type,
    ])
        ->assertStatus($code);
})->with([
    ['type' => 'like', 'code' => 201],
    ['type' => 'unlike', 'code' => 201],
    ['type' => 'dislike', 'code' => 422],
]);
