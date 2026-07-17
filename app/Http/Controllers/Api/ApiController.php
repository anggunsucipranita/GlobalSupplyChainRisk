<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function countries()
    {
        try {

            $response = Http::get(
                'https://raw.githubusercontent.com/mledoze/countries/master/countries.json'
            );

            if ($response->successful()) {

                return response()->json(

                    collect($response->json())
                        ->sortBy('name.common')
                        ->values()

                );

            }

        } catch (\Exception $e) {

        }

        return response()->json([]);
    }

    public function news()
    {
        try {

            $response = Http::get(
                'https://gnews.io/api/v4/search',
                [
                    'q' => 'logistics',
                    'lang' => 'en',
                    'token' => env('GNEWS_API_KEY')
                ]
            );

            if ($response->successful()) {

                return response()->json(
                    $response->json()['articles'] ?? []
                );

            }

        } catch (\Exception $e) {

        }

        return response()->json([]);
    }

    public function currency()
    {
        try {

            $response = Http::get(
                'https://open.er-api.com/v6/latest/USD'
            );

            if ($response->successful()) {

                return response()->json(
                    $response->json()
                );

            }

        } catch (\Exception $e) {

        }

        return response()->json([]);
    }

    public function risk()
    {
        return response()->json([

            'weather_weight'   => 30,
            'inflation_weight' => 20,
            'currency_weight'  => 10,
            'news_weight'      => 25,
            'port_weight'      => 15,

            'formula' => 'Weather + Inflation + Currency + News + Port'

        ]);
    }

    public function ports()
    {
        return response()->json([

            [
                'name'    => 'Port of Singapore',
                'country' => 'Singapore'
            ],

            [
                'name'    => 'Port of Shanghai',
                'country' => 'China'
            ],

            [
                'name'    => 'Port of Tanjung Priok',
                'country' => 'Indonesia'
            ],

            [
                'name'    => 'Port of Hamburg',
                'country' => 'Germany'
            ]

        ]);
    }
}