<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class RiskController extends Controller
{
    public function index()
    {
        // ===========================
        // Ambil semua negara
        // ===========================

        $countries = Http::get(
            'https://raw.githubusercontent.com/mledoze/countries/master/countries.json'
        )->json();

        $countries = collect($countries)
            ->sortBy('name.common')
            ->values();

        $country = request('country', 'IDN');

        $selectedCountry = $countries->first(function ($item) use ($country) {
            return $item['cca3'] == $country;
        });

        $countryName = $selectedCountry['name']['common'];

        // ===========================
        // WEATHER API
        // ===========================

        $lat = $selectedCountry['latlng'][0];
        $lon = $selectedCountry['latlng'][1];

        $weather = Http::get(
            'https://api.open-meteo.com/v1/forecast',
            [
                'latitude' => $lat,
                'longitude' => $lon,
                'current' => 'rain'
            ]
        )->json();

        $rain = $weather['current']['rain'] ?? 0;

        if ($rain == 0) {

            $weatherRisk = 10;

        } elseif ($rain <= 5) {

            $weatherRisk = 40;

        } elseif ($rain <= 15) {

            $weatherRisk = 70;

        } else {

            $weatherRisk = 90;

        }

        // ===========================
        // ECONOMY API
        // ===========================

        $inflation = null;

        try {

            $response = Http::get(
                "https://api.worldbank.org/v2/country/{$country}/indicator/FP.CPI.TOTL.ZG?format=json&per_page=10"
            );

            if ($response->successful()) {

                $json = $response->json();

                if (isset($json[1])) {

                    foreach ($json[1] as $item) {

                        if ($item['value'] != null) {

                            $inflation = $item['value'];
                            break;

                        }

                    }

                }

            }

        } catch (\Exception $e) {

            $inflation = null;

        }

        if ($inflation === null) {

            $economyRisk = 40;

        } elseif ($inflation < 3) {

            $economyRisk = 20;

        } elseif ($inflation < 6) {

            $economyRisk = 50;

        } else {

            $economyRisk = 90;

        }

        // ===========================
        // CURRENCY API
        // ===========================

        $currencyRisk = 30;
        $currencyCode = '-';
        $rate = null;

        try {

            $currencyResponse = Http::get(
                "https://open.er-api.com/v6/latest/USD"
            );

            if ($currencyResponse->successful()) {

                $currencyData = $currencyResponse->json();

                if (isset($selectedCountry['currencies'])) {

                    $currencyCode = array_key_first($selectedCountry['currencies']);

                    if (isset($currencyData['rates'][$currencyCode])) {

                        $rate = $currencyData['rates'][$currencyCode];

                        if ($rate < 0.5) {

                            $currencyRisk = 70;

                        } elseif ($rate < 1) {

                            $currencyRisk = 50;

                        } else {

                            $currencyRisk = 20;

                        }

                    }

                }

            }

        } catch (\Exception $e) {

            $currencyRisk = 30;

        }

        // ===========================
// NEWS API
// ===========================

$newsRisk = 20;
$newsCount = 0;

try {

    $newsResponse = Http::get(
        "https://gnews.io/api/v4/search",
        [
            'q' => $countryName,
            'lang' => 'en',
            'max' => 10,
            'apikey' => env('GNEWS_API_KEY')
        ]
    );

    if ($newsResponse->successful()) {

        $news = $newsResponse->json();

        $newsCount = count($news['articles'] ?? []);

        if ($newsCount >= 8) {

            $newsRisk = 80;

        } elseif ($newsCount >= 5) {

            $newsRisk = 60;

        } elseif ($newsCount >= 2) {

            $newsRisk = 40;

        } else {

            $newsRisk = 20;

        }

    }

} catch (\Exception $e) {

    $newsRisk = 20;

}

// ===========================
// PORT API
// ===========================

$portRisk = 50;
$totalPorts = 0;

try {

    $portResponse = Http::get('https://pocketworld.org/api/ports');

    if ($portResponse->successful()) {

        $allPorts = $portResponse->json()['ports'];

        // Cari pelabuhan berdasarkan negara yang dipilih
        $countryPorts = array_filter($allPorts, function ($port) use ($countryName) {

            return strtolower($port['country']) == strtolower($countryName);

        });

        $totalPorts = count($countryPorts);

        // Hitung risk berdasarkan jumlah pelabuhan
        if ($totalPorts >= 20) {

            $portRisk = 20;

        } elseif ($totalPorts >= 10) {

            $portRisk = 40;

        } elseif ($totalPorts >= 5) {

            $portRisk = 60;

        } elseif ($totalPorts >= 1) {

            $portRisk = 80;

        } else {

            $portRisk = 90;

        }

    }

} catch (\Exception $e) {

    $portRisk = 50;

}

        // ===========================
        // RISK SCORE
        // ===========================

        $risk = [

            'weather' => $weatherRisk,

            'economy' => $economyRisk,

            'currency' => $currencyRisk,

            'news' => $newsRisk,

            'port' => $portRisk,

        ];

        $score = round(array_sum($risk) / count($risk));

        if ($score <= 30) {

            $level = "LOW";
            $color = "success";

        } elseif ($score <= 60) {

            $level = "MEDIUM";
            $color = "warning";

        } else {

            $level = "HIGH";
            $color = "danger";

        }

        $updatedAt = now()->format('d M Y H:i');

        return view(
            'risk.index',
            compact(
                'countries',
                'country',
                'countryName',
                'risk',
                'score',
                'level',
                'color',
                'inflation',
                'currencyCode',
                'rate',
                'newsCount',
                'totalPorts',
                'rain',
                'updatedAt',
            )
        );
    }
}