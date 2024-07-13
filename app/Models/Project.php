<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'company_id',
        'conditions',
        'cover',
        'start_date',
        'end_date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function targetGroups()
    {
        return $this->hasMany(TargetGroup::class);
    }

    public function projectUsers()
    {
        return $this->hasMany(ProjectUser::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'project_categories');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_users');
    }

    public function getTasksWithQuestionCountsAttribute()
    {
        return $this->tasks()->withCount(['questions', 'questions as answered_questions_count' => function ($query) {
            $query->whereHas('answers');
        }])->get();
    }
}
