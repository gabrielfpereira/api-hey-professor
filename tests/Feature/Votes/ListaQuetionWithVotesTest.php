<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

test("deve listar a pergunta com a quantidade de votos", function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['status' => 'published']);
    $question->votes()->create(['user_id' => $user->id, 'value' => 0]);

    Sanctum::actingAs($user);
    $response = $this->getJson(route('questions.index'));

    $response->assertStatus(200);
    $response->assertJsonFragment([
        'id'               => $question->id,
        'sum_votes_like'   => 0,
        'sum_votes_unlike' => 1,
    ]);
});
