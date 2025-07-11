<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

test("usuario deve estar autenticado para restaurar uma pergunta", function () {
    $response = $this->putJson(route('questions.restore', ['question' => 1]))
        ->assertUnauthorized();
});

test("somento o dono da pergunta pode restaurar", function () {
    $user      = User::factory()->create();
    $question  = Question::factory()->create(['user_id' => $user->id]);
    $otherUser = User::factory()->create();

    Sanctum::actingAs($otherUser);
    $this->putJson(route('questions.restore', ['question' => $question->id]))
        ->assertForbidden();
});

test("usuario deve conseguir restaurar uma pergunta", function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['user_id' => $user->id]);
    $question->delete();

    Sanctum::actingAs($user);
    $response = $this->putJson(route('questions.restore', ['question' => $question->id]))
        ->assertNoContent();

    $this->assertDatabaseHas('questions', [
        'id'         => $question->id,
        'deleted_at' => null,
    ]);
});
