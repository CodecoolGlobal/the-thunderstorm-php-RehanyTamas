<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Date extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',  // Add 'datetime' to the $fillable array
        'name',
        'data_id',
    ];


    public function weatherData(): BelongsTo
    {
        return $this->belongsTo(WeatherData::class, 'data_id');
    }

}
