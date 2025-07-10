<?php

use Laravel\Sanctum\Sanctum;

it('can store questions', function () {
    $user = \App\Models\User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->postJson(route('questions.store'), [
        'question' => 'Sample Question Title?',
    ]);

    $response->assertCreated();
    $this->assertDatabaseHas('questions', [
        'question' => 'Sample Question Title?',
        'user_id'  => $user->id,
        'status'   => 'draft', // Assuming the default status is 'draft'
    ]);
});

it('a pergunta deve ter pelo menos 10 caracteres', function () {
    $user = \App\Models\User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->postJson(route('questions.store'), [
        'question' => 'Short',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['question']);
});

it('a pergunta é obrigatória', function () {
    $user = \App\Models\User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->postJson(route('questions.store'), []);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['question']);
});

it('o usuário deve estar autenticado', function () {
    $response = $this->postJson(route('questions.store'), [
        'question' => 'Sample Question Title',
    ]);

    $response->assertUnauthorized();
});

it('a pergunta deve ter uma interrogação no final', function () {
    $user = \App\Models\User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->postJson(route('questions.store'), [
        'question' => 'This is a question without a question mark',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['question']);
});
