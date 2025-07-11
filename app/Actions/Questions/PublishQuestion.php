<?php

namespace App\Actions\Questions;

use App\Models\Question;
use Illuminate\Support\Facades\Gate;

class PublishQuestion
{
    public function handle(Question $question): void
    {
        Gate::authorize('publish', $question);

        $question->update(['status' => 'published']);
    }
}
