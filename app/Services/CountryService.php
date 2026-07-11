<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CountryService
{
    public function getCountries()
    {
        try {

            $response = Http::get(
                'https://raw.githubusercontent.com/mledoze/countries/master/countries.json'
            );

            if ($response->successful()) {

                return collect($response->json())
                    ->sortBy('name.common')
                    ->values();

            }

        } catch (\Exception $e) {

        }

        return collect([]);
    }

    public function getCountry($code)
    {
        $countries = $this->getCountries();

        return $countries->first(function ($country) use ($code) {

            return isset($country['cca3']) &&
                   $country['cca3'] == strtoupper($code);

        });
    }
}