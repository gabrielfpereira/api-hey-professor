<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

test("somente usuários autenticados podem acessar este recurso", function () {
    $response = $this->deleteJson(route('questions.archive', ['question' => 1]));

    $response->assertUnauthorized();
});

test("somente o dono da questão pode arquivar a questão", function () {
    $user      = User::factory()->create();
    $question  = Question::factory()->create(['user_id' => $user->id]);
    $otherUser = User::factory()->create();

    Sanctum::actingAs($otherUser);
    $response = $this->deleteJson(route('questions.archive', ['question' => $question->id]));

    $response->assertForbidden();
    $this->assertDatabaseHas('questions', [
        'id'         => $question->id,
        'deleted_at' => null,
    ]);
});

test("a pergunta deve ser arquivada", function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);
    $response = $this->deleteJson(route('questions.archive', ['question' => $question->id]));

    $response->assertNoContent();
    $this->assertSoftDeleted('questions', [
        'id' => $question->id,
    ]);

});
