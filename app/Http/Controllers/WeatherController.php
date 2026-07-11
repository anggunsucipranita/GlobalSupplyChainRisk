<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        try {

            // Ambil semua negara
            $countries = Http::get(
                'https://raw.githubusercontent.com/mledoze/countries/master/countries.json'
            )->json();

            $countries = collect($countries)
                ->sortBy('name.common')
                ->values();

            // Default Indonesia
            $selected = request('country', 'IDN');

            // Cari negara
            $country = $countries->first(function ($item) use ($selected) {
                return $item['cca3'] == $selected;
            });

            $latitude = $country['latlng'][0];
            $longitude = $country['latlng'][1];

            // Ambil cuaca
            $response = Http::get(
                'https://api.open-meteo.com/v1/forecast',
                [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'current' => 'temperature_2m,wind_speed_10m,rain'
                ]
            );

            $weather = $response->json();

            $weather['latitude'] = $latitude;
            $weather['longitude'] = $longitude;
            $weather['city'] = $country['name']['common'];

        } catch (\Exception $e) {

            $countries = collect();
            $weather = [];

            $selected = null;

        }

        return view(
            'weather.index',
            compact(
                'countries',
                'weather',
                'selected'
            )
        );
    }
}