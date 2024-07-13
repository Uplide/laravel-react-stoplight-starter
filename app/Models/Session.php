<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ip_address', 'user_agent', 'last_activity', 'token', 'admin_id', "role"];


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
