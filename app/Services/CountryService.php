<?php

namespace App\Services;

use App\Models\Country;

class CountryService
{
    public function getCountries()
    {
        return Country::orderBy('country_name')->get();
    }

    public function getCountry($code)
    {
        return Country::where('cca3', strtoupper($code))->first();
    }
}