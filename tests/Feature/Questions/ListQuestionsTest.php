<?php

use Laravel\Sanctum\Sanctum;

test("deve listar as perguntas", function () {
    $user          = \App\Models\User::factory()->create();
    $question      = \App\Models\Question::factory()->create(['status' => 'published', 'user_id' => $user->id]);
    $otherQuestion = \App\Models\Question::factory()->create(['status' => 'published']);

    Sanctum::actingAs($user);

    $response = $this->getJson(route('questions.index'));
    $response->assertOk();

    $response->assertJsonFragment([
        'id'       => $question->id,
        'question' => $question->question,
        'status'   => 'published',
        'user_id'  => $user->id,
    ]);
    $response->assertJsonFragment([
        'id'       => $otherQuestion->id,
        'question' => $otherQuestion->question,
        'status'   => 'published',
    ]);
});

test("as perguntas devem estar publicadas", function () {
    $user              = \App\Models\User::factory()->create();
    $questionDraft     = \App\Models\Question::factory()->create(['status' => 'draft']);
    $questionPublished = \App\Models\Question::factory()->create(['status' => 'published']);

    Sanctum::actingAs($user);

    $response = $this->getJson(route('questions.index'));
    $response->assertOk();

    $response->assertJsonFragment([
        'id'       => $questionPublished->id,
        'question' => $questionPublished->question,
        'status'   => 'published',
    ]);
    $response->assertJsonMissing([
        'id'       => $questionDraft->id,
        'question' => $questionDraft->question,
        'status'   => 'draft',
    ]);
});

test("listar perguntas com status draft", function () {
    $user              = \App\Models\User::factory()->create();
    $questionDraft     = \App\Models\Question::factory()->create(['status' => 'draft']);
    $questionPublished = \App\Models\Question::factory()->create(['status' => 'published']);

    Sanctum::actingAs($user);

    $response = $this->getJson(route('questions.index', ['status' => 'draft']));
    $response->assertOk();

    $response->assertJsonFragment([
        'id'       => $questionDraft->id,
        'question' => $questionDraft->question,
        'status'   => 'draft',
    ]);
    $response->assertJsonMissing([
        'id'       => $questionPublished->id,
        'question' => $questionPublished->question,
        'status'   => 'published',
    ]);
});

test("listar com perguntas deletadas", function () {
    $user            = \App\Models\User::factory()->create();
    $questionDeleted = \App\Models\Question::factory()->create();
    $questionDeleted->delete();

    $questionPublished = \App\Models\Question::factory()->create(['status' => 'published']);

    Sanctum::actingAs($user);

    $response = $this->getJson(route('questions.index', ['status' => 'deleted']));
    $response->assertOk();

    $response->assertJsonFragment([
        'id'         => $questionDeleted->id,
        'question'   => $questionDeleted->question,
        'deleted_at' => $questionDeleted->deleted_at,
    ]);
});

test("listar somente perguntas do usuario logado", function () {
    $user              = \App\Models\User::factory()->create();
    $questionUser      = \App\Models\Question::factory()->create(['user_id' => $user->id]);
    $questionOtherUser = \App\Models\Question::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->getJson(route('questions.index', ['status' => 'owner']));
    $response->assertOk();

    $response->assertJsonFragment([
        'id'       => $questionUser->id,
        'question' => $questionUser->question,
        'user_id'  => $user->id,
    ]);
    $response->assertJsonMissing([
        'id'       => $questionOtherUser->id,
        'question' => $questionOtherUser->question,
    ]);
});
