<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [

        'country_id',

        'currency_code',

        'exchange_rate',

        'updated_at_api'

    ];

    protected $casts = [

        'updated_at_api' => 'datetime'

    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}