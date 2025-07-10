<?php

namespace App\Actions\Questions;

use App\DTOs\QuestionDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CreateQuestion
{
    /**
     * Handle the creation of a new question.
     *
     * @param  QuestionDTO  $data
     * @return \App\Models\Question
     */
    public function handle(QuestionDTO $data)
    {
        $data = $this->validate($data->toArray());

        return \App\Models\Question::create([
            'question' => $data['question'],
            'user_id' => Auth::id(),
        ]);
    }


    /**
     * Validate the question data.
     *
     * @param  array  $data
     * @return array
     */
    private function validate(array $data)
    {
        return Validator::make($data, [
            'question' => 'required|string|min:10|ends_with:?'
        ])->validate();
    }
}