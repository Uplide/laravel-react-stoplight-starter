<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_question_answer_id',
        'option_id'
    ];

    public function userQuestionAnswer()
    {
        return $this->belongsTo(UserQuestionAnswer::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
