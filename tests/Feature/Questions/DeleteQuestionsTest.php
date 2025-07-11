<?php

use Laravel\Sanctum\Sanctum;

test("apenas usuario logoado pode deletar perguntas", function () {
    $user     = \App\Models\User::factory()->create();
    $question = \App\Models\Question::factory()->create(['user_id' => $user->id]);

    $this->deleteJson(route('questions.destroy', $question))
        ->assertUnauthorized();
});

test('apenas o dono da pergunta pode deletar', function () {
    $user     = \App\Models\User::factory()->create();
    $question = \App\Models\Question::factory()->create([
        'user_id' => $user->id,
    ]);
    $anotherUser = \App\Models\User::factory()->create();

    Sanctum::actingAs($anotherUser);

    $this->deleteJson(route('questions.destroy', $question))
        ->assertForbidden();

    $this->assertDatabaseHas('questions', [
        'id'      => $question->id,
        'user_id' => $user->id,
    ]);
});

test('deletar pergunta', function () {
    $user     = \App\Models\User::factory()->create();
    $question = \App\Models\Question::factory()->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    $this->deleteJson(route('questions.destroy', $question))
        ->assertNoContent();

    $this->assertDatabaseMissing('questions', [
        'id' => $question->id,
    ]);
});
