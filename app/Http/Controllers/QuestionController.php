<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\{Request, Response};

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $question = new \App\DTOs\QuestionDTO(
            question: $request->input('question'),
        );

        $question = app(\App\Actions\Questions\CreateQuestion::class)
            ->handle($question);

        return response()->json($question, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $questionDTO = new \App\DTOs\QuestionDTO(
            question: $request->input('question'),
            status: $question->status,
        );

        $question = app(\App\Actions\Questions\UpdateQuestion::class)
            ->handle($questionDTO, $question);

        return response()->json($question, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        app(\App\Actions\Questions\DeleteQuestion::class)
            ->handle($question);

        return response()->noContent();
    }
}
