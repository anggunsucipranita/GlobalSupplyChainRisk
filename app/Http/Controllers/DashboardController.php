<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Country;
use App\Services\RiskScoreService;
use App\Services\WeatherService;
use App\Models\NewsCache;
use App\Services\CurrencyService;
use App\Models\Economy;

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

        $riskService = new RiskScoreService();

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
WEATHER CACHE SERVICE
======================================================
*/

$weather = [

    'temperature' => 0,

    'wind' => 0,

    'rain' => 0,

    'weather' => '-'

];


$weatherService = new WeatherService();


if ($countryData) {

    $weather = $weatherService->getWeather($countryData);

}


$temperature = $weather['temperature'] ?? 0;

$windSpeed = $weather['wind'] ?? 0;

$rain = $weather['rain'] ?? 0;
    

        
        $economy = null;

if ($countryData) {

    $country = Country::where('cca3', $selectedCountry)->first();

    if ($country) {

        $economy = Economy::where(
            'country_id',
            $country->id
        )->first();

    }

}

if (!$economy) {

    $economy = (object)[

        'gdp' => null,

        'inflation' => null,

        'population' => 0,

        'export' => null,

        'import' => null,

    ];

}

$population = $economy->population ?? 0;

       /*
======================================================
CURRENCY CACHE
======================================================
*/

$currencyService = new CurrencyService();

$currency = [];

$exchangeRate = null;


if ($countryData) {

    $currency = $currencyService->getCurrency($countryData);

    $exchangeRate = $currency['rate'] ?? null;

}

        /*
======================================================
NEWS CACHE
======================================================
*/

$news = NewsCache::latest('published_at')
        ->take(5)
        ->get();

$newsCount = $news->count();

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

        if (is_null($economy->inflation)) {

    $economyRisk = 30;

} elseif ($economy->inflation <= 3) {

    $economyRisk = 15;

} elseif ($economy->inflation <= 6) {

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

        $country = Country::where('cca3', $selectedCountry)->first();

if ($country) {

    $risk = $riskService->updateRisk(

        $country,

        $weatherRisk,

        $economyRisk,

        $currencyRisk,

        $newsRisk,

        $portRisk

    );

}

        /*
        ======================================================
        FINAL RISK SCORE
        ======================================================
        */

        $risk = $country ? $country->riskScore : null;

$badge = "secondary";

$riskScore = 0;

$riskLevel = "Unknown";

$recommendation = "-";


if ($country) {

    $risk = $country->riskScore;

}


if ($risk) {

    $weatherRisk = $risk->weather_risk;

    $economyRisk = $risk->economy_risk;

    $currencyRisk = $risk->currency_risk;

    $newsRisk = $risk->news_risk;

    $portRisk = $risk->port_risk;

    $riskScore = $risk->overall_risk;

    $riskLevel = $risk->risk_level . ' Risk';


    switch ($riskLevel) {

        case "Low Risk":

            $badge = "success";

            $recommendation = "Import can continue safely.";

            break;


        case "Medium Risk":

            $badge = "warning";

            $recommendation = "Import can continue with monitoring.";

            break;


        case "High Risk":

            $badge = "danger";

            $recommendation = "Delay shipment until conditions improve.";

            break;

    }

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