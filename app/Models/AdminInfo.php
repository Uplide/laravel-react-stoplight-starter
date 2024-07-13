<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminInfo extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'phone', 'address'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
