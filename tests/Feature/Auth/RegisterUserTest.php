<?php

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Response;

test("email é um campo obrigatório", function(){

    $this->postJson(route('register'), [
        'name' => 'John Doe',
        'email' => '',
        'password' => 'password',
    ])
    ->assertJsonValidationErrors('email');
});

test("nome é um campo obrigatório", function(){
    $this->postJson(route('register'), [
        'name' => '',
        'email' => 'john@example.com',
        'password' => 'password',
    ])
    ->assertJsonValidationErrors('name');
});

test("senha é um campo obrigatório", function(){
    $this->postJson(route('register'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => '',
    ])
    ->assertJsonValidationErrors('password');
});

test("senha deve ser maior que 8 caracteres", function(){
    $this->postJson(route('register'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'pass',
    ])
    ->assertJsonValidationErrors('password');
});

test("senha deve ser salva em hash", function(){
    $this->postJson(route('register'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
    ])
    ->assertStatus(Response::HTTP_CREATED);

    $this->assertDatabaseMissing('users', [
        'password' => 'password',
    ]);

    $user = User::where('email', 'john@example.com')->first();
    Hash::check('password', $user->password);
});