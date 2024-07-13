<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cover',
        'sort',
        'color',
    ];

    protected $table = 'categories';

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_categories');
    }
}
