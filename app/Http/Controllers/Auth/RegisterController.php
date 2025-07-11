<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response};

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $user = app(\App\Actions\Auth\RegisterUser::class)->handle($request);

        return response()->json($user, Response::HTTP_CREATED);
    }
}
