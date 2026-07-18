<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCache extends Model
{
    protected $fillable = [

        'country_id',

        'title',

        'description',

        'image',

        'url',

        'source',

        'published_at',

        'sentiment',

        'positive',

        'negative'

    ];

    protected $casts = [

        'published_at' => 'datetime'

    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}