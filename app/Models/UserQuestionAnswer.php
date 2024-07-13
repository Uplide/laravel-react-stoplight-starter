<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'user_id',
        'text_answer',
        'video_path',
        'image_path',
        'voice_path',
        'parent_id',
        "is_editable"
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(UserQuestionAnswer::class, 'parent_id');
    }

    public function answerOptions()
    {
        return $this->hasMany(AnswerOption::class);
    }

    public function subAnswers()
    {
        return $this->hasMany(UserQuestionAnswer::class, 'parent_id');
    }

    public function likes()
    {
        return $this->hasMany(UserQuestionAnswerLike::class);
    }
}
