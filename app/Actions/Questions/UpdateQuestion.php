<?php

namespace App\Actions\Questions;

use App\DTOs\QuestionDTO;
use App\Models\Question;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\{Auth, Validator};

class UpdateQuestion
{
    public function handle(QuestionDTO $questionDTO, Question $question): Question
    {
        $this->authorize($question);

        $data = $this->validate($questionDTO->toArray());

        $question->update($data);

        return $question;
    }

    private function validate(array $data)
    {
        return Validator::make($data, [
            'question' => 'required|string|min:10|ends_with:?',
        ])->validate();
    }

    private function authorize(Question $question): void
    {
        if (Auth::id() !== $question->user_id) {
            abort(Response::HTTP_FORBIDDEN, 'Você não tem permissão para atualizar esta questão.');
        }
    }
}
