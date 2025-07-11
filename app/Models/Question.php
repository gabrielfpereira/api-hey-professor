<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
