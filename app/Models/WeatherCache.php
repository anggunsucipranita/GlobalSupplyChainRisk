<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherCache extends Model
{
    protected $fillable = [

        'country_id',

        'temperature',

        'wind_speed',

        'rain',

        'humidity',

        'weather',

        'last_updated'

    ];

    protected $casts = [

        'last_updated' => 'datetime'

    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}