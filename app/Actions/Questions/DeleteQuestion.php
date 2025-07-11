<?php

namespace App\Actions\Questions;

use Illuminate\Support\Facades\Gate;

class DeleteQuestion
{
    public function handle(\App\Models\Question $question): void
    {
        Gate::authorize('delete', $question);

        $question->delete();
    }
}
