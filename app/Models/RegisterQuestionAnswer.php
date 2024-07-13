<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterQuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer',
        'register_question_id',
        'user_id',
        'register_question_option_id',
    ];
}
