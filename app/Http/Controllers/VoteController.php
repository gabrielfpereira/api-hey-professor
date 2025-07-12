<?php

namespace App\Http\Controllers;

use App\Actions\Votes\CreateVote;
use App\Models\Question;
use Illuminate\Http\{Request, Response};

class VoteController extends Controller
{
    public function store(Request $request, Question $question)
    {
        app(CreateVote::class)->handle($request, $question);

        return response()->json([], Response::HTTP_CREATED);
    }
}
