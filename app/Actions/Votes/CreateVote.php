<?php

namespace App\Actions\Votes;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Gate, Validator};

class CreateVote
{
    public function handle(Request $request, Question $question)
    {
        $data = $this->validate($request->all());

        Gate::authorize('vote', $question);

        $question->votes()->create([
            'user_id' => $request->user()->id,
            'value'   => $data['type'] === 'like' ? 1 : 0,
        ]);
    }

    public function validate(array $data)
    {
        return Validator::make($data, [
            'type' => 'required|in:like,unlike',
        ])->validate();
    }
}
