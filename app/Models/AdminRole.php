<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'admin_id'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
