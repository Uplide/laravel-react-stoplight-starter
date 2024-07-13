<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterQuestionOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'sort',
        'register_question_id',
    ];
}
