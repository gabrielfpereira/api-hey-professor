<?php

namespace App\Actions\Questions;

use App\Models\Question;
use Illuminate\Support\Facades\Gate;

class PublishQuestion
{
    public function handle(Question $question)
    {
        Gate::authorize('publish', $question);

        $question->status = 'published';
        $question->save();
    }
}
