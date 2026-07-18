<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Economy extends Model
{
    protected $fillable = [

        'country_id',

        'gdp',

        'inflation',

        'population',

        'export',

        'import'

    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}