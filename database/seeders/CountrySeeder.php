<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        Country::truncate();

        $response = Http::get(
            'https://raw.githubusercontent.com/mledoze/countries/master/countries.json'
        );

        if (!$response->successful()) {
            return;
        }

        foreach ($response->json() as $country) {

            Country::create([

                'cca3' => $country['cca3'] ?? null,

                'cca2' => $country['cca2'] ?? null,

                'country_name' => $country['name']['common'] ?? null,

                'capital' => $country['capital'][0] ?? null,

                'region' => $country['region'] ?? null,

                'population' => $country['population'] ?? 0,

                'currency' => array_key_first($country['currencies'] ?? []),

                'language' => implode(', ', array_values($country['languages'] ?? [])),

                'flag' => $country['flag'] ?? '',

                'latitude' => $country['latlng'][0] ?? null,

                'longitude' => $country['latlng'][1] ?? null,

            ]);

        }
    }
}