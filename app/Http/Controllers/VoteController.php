<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Gate;

class VoteController extends Controller
{
    public function store(Request $request, Question $question)
    {
        $data = $request->validate([
            'type' => 'required|in:like,unlike',
        ]);

        Gate::authorize('vote', $question);

        $question->votes()->create([
            'user_id' => $request->user()->id,
            'value'   => $data['type'] === 'like' ? 1 : 0,
        ]);

        return response()->json([], Response::HTTP_CREATED);
    }
}
