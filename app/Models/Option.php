<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'option_name',
        'option_value',
        'sort'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answerOptions()
    {
        return $this->hasMany(AnswerOption::class);
    }
}
