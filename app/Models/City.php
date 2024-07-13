<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_name',
        'plate_no',
        'phone_code',
        'status',
        'country_id',
        'latitude',
        'longitude',
    ];

    // Her şehrin birden fazla ilçesi olabilir
    public function towns()
    {
        return $this->hasMany(Town::class);
    }

    // Her şehir bir ülkeye ait olabilir
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
