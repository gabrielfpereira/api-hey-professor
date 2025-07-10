<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

test("o usuario deve ser autenticado para atualizar uma questão", function () {

    $response = $this->putJson('/api/questions/1', [
        'question' => 'Nova pergunta',
    ]);

    $response->assertUnauthorized();
});

it("o usuario dever ser o dono da questão para atualizá-la", function () {
    $user      = User::factory()->create();
    $question  = Question::factory()->create(['user_id' => $user->id]);
    $otherUser = User::factory()->create();

    Sanctum::actingAs($otherUser);

    $response = $this->putJson('/api/questions/' . $question->id, [
        'question' => 'Nova pergunta ?',
    ]);

    $response->assertForbidden();
    expect($question->fresh()->question)->toBe($question->question);

});

test("a pergunta deve ter no minimo 10 caracteres", function () {

    $user     = User::factory()->create();
    $question = Question::factory()->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    $response = $this->putJson('/api/questions/' . $question->id, [
        'question' => 'Curta ?',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['question']);
    expect($question->fresh()->question)->toBe($question->question);
});

test("a pergunta não pode ser vazia", function () {

    $user     = User::factory()->create();
    $question = Question::factory()->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    $response = $this->putJson('/api/questions/' . $question->id, [
        'question' => '',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['question']);
    expect($question->fresh()->question)->toBe($question->question);
});

test("a pergunta deve ter uma interrogação no final", function () {

    $user     = User::factory()->create();
    $question = Question::factory()->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    $response = $this->putJson('/api/questions/' . $question->id, [
        'question' => 'Pergunta sem interrogação',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['question']);
    expect($question->fresh()->question)->toBe($question->question);
});

test("a pergunta deve ser atualizada com sucesso", function () {

    $user     = User::factory()->create();
    $question = Question::factory()->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    $response = $this->putJson('/api/questions/' . $question->id, [
        'question' => 'Nova pergunta ?',
    ]);

    $response->assertOk();
    expect($question->fresh()->question)->toBe('Nova pergunta ?');
});
