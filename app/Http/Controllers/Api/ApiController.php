<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\RiskScore;
use App\Models\NewsCache;
use App\Models\Currency;
use App\Models\Port;

class ApiController extends Controller
{

    public function countries()
{
    return response()->json(

        Country::orderBy('country_name')->get()

    );
}


    public function news()
    {
        return response()->json(

            NewsCache::latest('published_at')
                ->take(20)
                ->get()

        );
    }


    public function currency()
    {
        return response()->json(

            Currency::with('country')->get()

        );
    }


    public function risk()
    {
        return response()->json(

            RiskScore::with('country')->get()

        );
    }


    public function ports()
{
    return response()->json(
        Port::all()
    );
}

}