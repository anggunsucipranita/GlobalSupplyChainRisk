<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [

        'cca3',

        'cca2',

        'country_name',

        'capital',

        'region',

        'population',

        'currency',

        'language',

        'flag',

        'latitude',

        'longitude'

    ];
    public function riskScore()
{
    return $this->hasOne(RiskScore::class);
}
public function weatherCache()
{
    return $this->hasOne(WeatherCache::class);
}
}