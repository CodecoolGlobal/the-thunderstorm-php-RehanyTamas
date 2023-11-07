<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WeatherData extends Model
{
    use HasFactory;

    protected $fillable = [
        'temperature_celsius',
        'precipitation_millimeter',
        'humidity_percent',
        'wind_speed',
    ];

    public function date(): HasOne
    {
        return $this->hasOne(Date::class, 'data_id');
    }

}
