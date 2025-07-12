<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

test("deve buscar uma pergunta", function () {
    $user      = User::factory()->create();
    $question1 = Question::factory()->create([
        'user_id'  => $user->id,
        'question' => 'Primeira Pergunta de teste',
        'status'   => 'published',
    ]);

    $question2 = Question::factory()->create([
        'user_id'  => $user->id,
        'question' => 'Outra pergunta de teste',
        'status'   => 'published',
    ]);

    Sanctum::actingAs($user);
    $response = $this->getJson(route('questions.index', ['search' => 'primeira']));

    $response->assertStatus(200);
    $response->assertJsonFragment([
        'id'       => $question1->id,
        'question' => 'Primeira Pergunta de teste',
    ]);
    $response->assertJsonMissing([
        'id'       => $question2->id,
        'question' => 'Outra pergunta de teste',
    ]);
});
