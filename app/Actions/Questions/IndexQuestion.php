<?php

namespace App\Actions\Questions;

use App\Models\Question;
use Illuminate\Http\Request;

class IndexQuestion
{
    public function handle(Request $request)
    {
        $questions = Question::query()
        ->with('votes')
        ->when($request->has('search'), function ($query) use ($request) {
            $query->where('question', 'like', "%{$request->input('search')}%");
        })
        ->when($request->has('status'), function ($query) use ($request) {
            if ($request->status === 'owner') {
                $query->where('user_id', $request->user()->id);
            }

            if ($request->status === 'draft') {
                $query->where('status', 'draft');
            }

            if ($request->status === 'deleted') {
                $query->withTrashed();
            }
        }, function ($query) {
            $query->where('status', 'published');
        })
        ->withSumVotesLike()
        ->withSumVotesUnlike()
        ->orderBy('sum_votes_like', 'desc')
        ->get();

        return $questions;
    }
}
