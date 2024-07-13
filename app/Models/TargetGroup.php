<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'ses',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'target_group_users');
    }
}
