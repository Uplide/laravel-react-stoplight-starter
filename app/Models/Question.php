<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'title',
        'description',
        'option_type',
        'sort'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function answers()
    {
        return $this->hasMany(UserQuestionAnswer::class);
    }

    public function answeredOptions()
    {
        return $this->hasManyThrough(AnswerOption::class, UserQuestionAnswer::class, 'question_id', 'user_question_answer_id', 'id', 'id');
    }

    public function scopeWithAnsweredOptions($query, $userId)
    {
        return $query->with(['options' => function ($query) use ($userId) {
            $query->withCount(['answerOptions as is_answered' => function ($query) use ($userId) {
                $query->whereHas('userQuestionAnswer', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            }])->orderBy('sort', "asc");
        }]);
    }

    public function getIsEditableAttribute()
    {
        $answer = $this->answers()->where('user_id', auth()->id())->first();
        if (!$answer) {
            return false;
        }

        if ($answer->is_editable) {
            return true;
        }

        $start = Carbon::parse($answer->created_at);
        $end = Carbon::now();
        $duration = $start->setDateFrom($end)->diffInMinutes($end);

        return $duration <= 10 && !UserQuestionAnswer::where("parent_id", $answer->id)->first();
    }
}
