<?php

test("deve deslogar o usuario", function () {
    $user  = \App\Models\User::factory()->create();
    $token = $user->createToken('token_api')->plainTextToken;

    $response = $this->post(route('logout'), [], ['Authorization' => 'Bearer ' . $token]);

    $response->assertNoContent();
});

test("o usuario deve ser autenticado para deslogar", function () {
    $response = $this->post(route('logout'));

    $response->assertRedirect();
});

test("deve revogar todos os tokens do usuario", function () {
    $user  = \App\Models\User::factory()->create();
    $token = $user->createToken('token_api')->plainTextToken;

    $response = $this->post(route('logout'), [], ['Authorization' => 'Bearer ' . $token]);

    $user->refresh();
    $tokens = $user->tokens;
    expect($tokens)->toBeEmpty();
});

test("depois de delogado o usuário não deve conseguir entrar em rotas autenticadas", function () {
    $user  = \App\Models\User::factory()->create();
    $token = $user->createToken('token_api')->plainTextToken;

    $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson('/api/auth/logout');

    $user->refresh();
    expect($user->tokens)->toBeEmpty();

});
