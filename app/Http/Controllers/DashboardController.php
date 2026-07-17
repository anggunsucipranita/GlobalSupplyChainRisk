<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        /*
        ======================================================
        COUNTRY API
        ======================================================
        */

        $selectedCountry = strtoupper($request->country ?? 'IDN');

        $countries = collect();

        $countryData = null;

        try {

            $response = Http::timeout(20)->get(
                'https://raw.githubusercontent.com/mledoze/countries/master/countries.json'
            );

            if ($response->successful()) {

                $countries = collect($response->json())
                    ->sortBy('name.common')
                    ->values();

                $countryData = $countries->first(function ($country) use ($selectedCountry) {

                    return isset($country['cca3']) &&
                        strtoupper($country['cca3']) === $selectedCountry;

                });

            }

        } catch (\Exception $e) {

            $countries = collect();

            $countryData = null;

        }

        /*
        ======================================================
        DEFAULT VALUE
        ======================================================
        */

        $countryName = '-';

        $capital = '-';

        $region = '-';

        $population = 0;

        $currencyCode = '-';

        $latitude = 0;

        $longitude = 0;

        if ($countryData) {

            $countryName = $countryData['name']['common'] ?? '-';

            $capital = $countryData['capital'][0] ?? '-';

            $region = $countryData['region'] ?? '-';

            $population = null;

            $latitude = $countryData['latlng'][0] ?? 0;

            $longitude = $countryData['latlng'][1] ?? 0;

            if (isset($countryData['currencies'])) {

                $currencyCode = array_key_first($countryData['currencies']);

            }

        }

    

        /*
        ======================================================
        WEATHER API (Open-Meteo)
        ======================================================
        */

        $weather = [];

        $temperature = null;

        $windSpeed = null;

        $rain = null;

        try {

            $response = Http::timeout(20)->get(
                'https://api.open-meteo.com/v1/forecast',
                [

                    'latitude' => $latitude,

                    'longitude' => $longitude,

                    'current' => 'temperature_2m,wind_speed_10m,rain'

                ]
            );

            if ($response->successful()) {

                $weather = $response->json();

                $temperature = $weather['current']['temperature_2m'] ?? null;

                $windSpeed = $weather['current']['wind_speed_10m'] ?? null;

                $rain = $weather['current']['rain'] ?? null;

            }

        } catch (\Exception $e) {

            $weather = [];

        }

        /*
        ======================================================
        WORLD BANK API
        ======================================================
        */

        $economy = [

            'gdp' => null,

            'inflation' => null,

            'population' => null,

            'export' => null,

            'import' => null,

        ];

        $indicators = [

            'gdp'        => 'NY.GDP.MKTP.CD',

            'inflation' => 'FP.CPI.TOTL.ZG',

            'population'=> 'SP.POP.TOTL',

            'export'    => 'NE.EXP.GNFS.CD',

            'import'    => 'NE.IMP.GNFS.CD',

        ];

        foreach ($indicators as $key => $indicator) {

            try {

                $response = Http::timeout(20)->get(

                    "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/{$indicator}",

                    [

                        'format' => 'json',

                        'per_page' => 20

                    ]

                );

                if ($response->successful()) {

                    $json = $response->json();

                    if (isset($json[1])) {

                        foreach ($json[1] as $item) {

                           if (!is_null($item['value'])) {

                                $economy[$key] = $item['value'];

                                 break;

                            }

                        }

                    }

                }

            } catch (\Exception $e) {

                $economy[$key] = null;

            }

        }

         /****************************************
        POPULATION
        ****************************************/

        if (!is_null($economy['population'])) {

                 $population = $economy['population'];

                    } else {

        $population = $countryData['population'] ?? 0;

                    }

        /*
        ======================================================
        EXCHANGE RATE API
        ======================================================
        */

        $currency = [];

        $exchangeRate = null;

        try {

            $response = Http::timeout(20)
                ->get('https://open.er-api.com/v6/latest/USD');

            if ($response->successful()) {

                $currency = $response->json();

                if (

                    $currencyCode != '-' &&

                    isset($currency['rates'][$currencyCode])

                ) {

                    $exchangeRate = $currency['rates'][$currencyCode];

                }

            }

        } catch (\Exception $e) {

            $currency = [];

            $exchangeRate = null;

        }

        /*
        ======================================================
        GNEWS API
        ======================================================
        */

        $news = [];

        $newsCount = 0;

        try {

            $response = Http::timeout(20)->get(
                'https://gnews.io/api/v4/search',
                [

                    'q' => $countryName . ' logistics OR economy OR trade',

                    'lang' => 'en',

                    'max' => 5,

                    'token' => env('GNEWS_API_KEY')

                ]
            );

            if ($response->successful()) {

                $news = $response->json()['articles'] ?? [];

                $newsCount = count($news);

            }

        } catch (\Exception $e) {

            $news = [];

            $newsCount = 0;

        }

        /*
        ======================================================
        PORT API
        ======================================================
        */

        $ports = [];

        $totalPorts = 0;

        try {

            $response = Http::timeout(20)->get(
                'https://pocketworld.org/api/ports'
            );

            if ($response->successful()) {

                $allPorts = data_get($response->json(), 'ports', []);

                $ports = collect($allPorts)
                    ->filter(function ($port) use ($countryName) {

                        return strtolower($port['country'] ?? '') ==
                               strtolower($countryName);

                    })
                    ->values()
                    ->toArray();

                $totalPorts = count($ports);

            }

        } catch (\Exception $e) {

            $ports = [];

            $totalPorts = 0;

        }

        /*
        ======================================================
        RISK ENGINE
        ======================================================
        */

        // Weather Risk

        if ($rain === null) {

            $weatherRisk = 20;

        } elseif ($rain <= 1) {

            $weatherRisk = 10;

        } elseif ($rain <= 5) {

            $weatherRisk = 35;

        } elseif ($rain <= 10) {

            $weatherRisk = 60;

        } else {

            $weatherRisk = 90;

        }

        // Inflation Risk

        if (is_null($economy['inflation'])) {

            $economyRisk = 30;

        } elseif ($economy['inflation'] <= 3) {

            $economyRisk = 15;

        } elseif ($economy['inflation'] <= 6) {

            $economyRisk = 45;

        } else {

            $economyRisk = 80;

        }

        // Currency Risk

        if (is_null($exchangeRate)) {

            $currencyRisk = 30;

        } elseif ($exchangeRate >= 1) {

            $currencyRisk = 20;

        } elseif ($exchangeRate >= 0.5) {

            $currencyRisk = 45;

        } else {

            $currencyRisk = 75;

        }

        // News Risk

        if ($newsCount >= 5) {

            $newsRisk = 70;

        } elseif ($newsCount >= 3) {

            $newsRisk = 50;

        } elseif ($newsCount >= 1) {

            $newsRisk = 30;

        } else {

            $newsRisk = 20;

        }

        // Port Risk

        if ($totalPorts >= 20) {

            $portRisk = 10;

        } elseif ($totalPorts >= 10) {

            $portRisk = 30;

        } elseif ($totalPorts >= 5) {

            $portRisk = 50;

        } elseif ($totalPorts >= 1) {

            $portRisk = 70;

        } else {

            $portRisk = 90;

        }

        /*
        ======================================================
        FINAL RISK SCORE
        ======================================================
        */

        $riskScore = round(

            ($weatherRisk * 0.30) +
            ($economyRisk * 0.20) +
            ($currencyRisk * 0.10) +
            ($newsRisk * 0.25) +
            ($portRisk * 0.15)

        );

        if ($riskScore <= 30) {

            $riskLevel = "Low Risk";

            $badge = "success";

            $recommendation = "Import can continue safely.";

        } elseif ($riskScore <= 60) {

            $riskLevel = "Medium Risk";

            $badge = "warning";

            $recommendation = "Import can continue with monitoring.";

        } else {

            $riskLevel = "High Risk";

            $badge = "danger";

            $recommendation = "Delay shipment until conditions improve.";

        }

        /*
        ======================================================
        CHART DATA
        ======================================================
        */

        $riskChart = [

            'labels' => [
                'Weather',
                'Inflation',
                'Currency',
                'News',
                'Port'
            ],

            'data' => [

                $weatherRisk,

                $economyRisk,

                $currencyRisk,

                $newsRisk,

                $portRisk

            ]

        ];

        /*
        ======================================================
        RETURN VIEW
        ======================================================
        */

        return view('dashboard.index', [

            'countries' => $countries,

            'selectedCountry' => $selectedCountry,

            'countryData' => $countryData,

            'countryName' => $countryName,

            'capital' => $capital,

            'region' => $region,

            'population' => $population,

            'currencyCode' => $currencyCode,

            'exchangeRate' => $exchangeRate,

            'weather' => $weather,

            'temperature' => $temperature,

            'windSpeed' => $windSpeed,

            'rain' => $rain,

            'economy' => $economy,

            'currency' => $currency,

            'news' => $news,

            'newsCount' => $newsCount,

            'ports' => $ports,

            'totalPorts' => $totalPorts,

            'weatherRisk' => $weatherRisk,

            'economyRisk' => $economyRisk,

            'currencyRisk' => $currencyRisk,

            'newsRisk' => $newsRisk,

            'portRisk' => $portRisk,

            'riskScore' => $riskScore,

            'riskLevel' => $riskLevel,

            'badge' => $badge,

            'recommendation' => $recommendation,

            'riskChart' => $riskChart,

            'latitude' => $latitude,

            'longitude' => $longitude,

        ]);

    }
}