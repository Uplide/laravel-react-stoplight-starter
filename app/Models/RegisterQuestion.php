<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'sort',
        'question_type',
    ];

    public function options()
    {
        return $this->hasMany(RegisterQuestionOption::class);
    }

    public function userQuestionAnswers()
    {
        return $this->hasMany(UserQuestionAnswer::class);
    }
}
