<?php

namespace App\Policies;

use App\Models\{Question, User};

class QuestionPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Question $question): bool
    {
        return $user->id === $question->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Question $question): bool
    {
        return $user->id === $question->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Question $question): bool
    {
        return $user->id === $question->user_id;
        ;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Question $question): bool
    {
        return $user->id === $question->user_id;
    }

    public function publish(User $user, Question $question): bool
    {
        return $user->id === $question->user_id && $question->status == 'draft';
    }

    public function vote(User $user, Question $question): bool
    {
        return $user->votes()
            ->where('question_id', $question->id)
            ->exists() === false
            && $user->id !== $question->user_id;
    }
}
