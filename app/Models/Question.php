<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * Relacionamento de votos
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Vote,$this>
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function scopeWithSumVotesLike(Builder $query): Builder
    {
        return $query->addSelect([
            'sum_votes_like' => Vote::select(DB::raw('count(*)'))
                ->whereColumn('votes.question_id', 'questions.id')
                ->where('value', 1),
        ]);
    }

    public function scopeWithSumVotesUnlike(Builder $query): Builder
    {
        return $query->addSelect([
            'sum_votes_unlike' => Vote::select(DB::raw('count(*)'))
                ->whereColumn('votes.question_id', 'questions.id')
                ->where('value', 0),
        ]);
    }
}
