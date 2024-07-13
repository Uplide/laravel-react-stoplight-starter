<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuestionAnswerLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        "user_question_answer_id"
    ];

    protected $table = 'user_question_answer_likes';
}
