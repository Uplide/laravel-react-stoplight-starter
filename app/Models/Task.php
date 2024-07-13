<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'cover',
        'start_date',
        'end_date',
        'sort',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
