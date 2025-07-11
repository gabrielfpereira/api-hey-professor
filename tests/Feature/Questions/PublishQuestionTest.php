<?php

use Laravel\Sanctum\Sanctum;

test("apenas usuario logado publicar perguntas", function () {
    $question = \App\Models\Question::factory()->create();

    $this->putJson(route('questions.publish', $question->id))
        ->assertUnauthorized();
});

test("apenas o dono da pergunta pode publicar", function () {
    $user      = \App\Models\User::factory()->create();
    $question  = \App\Models\Question::factory()->create();
    $otherUser = \App\Models\User::factory()->create();

    Sanctum::actingAs($otherUser);
    $this->putJson(route('questions.publish', $question->id))
        ->assertForbidden();

    $this->assertDatabaseMissing('questions', [
        'id'     => $question->id,
        'status' => 'published',
    ]);
});

test("o usuario deve conseguir publicar uma pergunta", function () {
    $user     = \App\Models\User::factory()->create();
    $question = \App\Models\Question::factory()->create([
        'user_id' => $user->id,
        'status'  => 'draft',
    ]);

    Sanctum::actingAs($user);
    $this->putJson(route('questions.publish', $question->id))
        ->assertNoContent();

    $this->assertDatabaseHas('questions', [
        'id'     => $question->id,
        'status' => 'published',
    ]);
});
