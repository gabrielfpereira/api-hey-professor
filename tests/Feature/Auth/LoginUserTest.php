<?php

test("o usuario deve passar campos obrigatórios", function () {
    $response = $this->postJson(route('login'), [
        'email'    => '',
        'password' => '',
    ]);
    $response->assertJsonValidationErrors([
        'email',
        'password',
    ]);

});

test("deve ser criado um token", function () {
    $user = \App\Models\User::factory()->create([
        'email'    => 'user@example.com',
        'password' => 'password',
    ]);

    $response = $this->postJson(route('login'), [
        'email'    => $user->email,
        'password' => 'password',
    ]);
    $response->assertJsonStructure([
        'token',
    ]);

    $user  = \App\Models\User::where('email', 'user@example.com')->first();
    $token = $user->tokens->first()->token;
    expect($token)->not()->toBeNull();
});

test("autenticar o usuario pelo token", function () {
    $user  = \App\Models\User::factory()->create();
    $token = $user->createToken('token')->plainTextToken;

    $response = $this->getJson('/api/dashboard', [
        'Authorization' => 'Bearer ' . $token,
    ]);
    $response->assertOk();
});
