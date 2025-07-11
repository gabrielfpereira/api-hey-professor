<?php

namespace App\Actions\Questions;

use App\Models\Question;
use Illuminate\Support\Facades\Gate;

class RestoreQuestion
{
    public function handle(int $question_id): void
    {
        $question = Question::withTrashed()->findOrFail($question_id);
        Gate::authorize('restore', $question);

        $question->restore();
    }
}
