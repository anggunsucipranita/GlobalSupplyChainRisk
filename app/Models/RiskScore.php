<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskScore extends Model
{
    protected $fillable = [

        'country_id',

        'weather_risk',

        'economy_risk',

        'currency_risk',

        'news_risk',

        'port_risk',

        'overall_risk',

        'risk_level'

    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}