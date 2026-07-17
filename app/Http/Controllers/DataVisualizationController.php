<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DataVisualizationController extends Controller
{
    public function index(Request $request)
    {
        $country = $request->country ?? 'IDN';

        $countryName = "Indonesia";

        $countries = collect();

        try {

            $countries = collect(

                Http::get(
                    'https://raw.githubusercontent.com/mledoze/countries/master/countries.json'
                )->json()

            )->sortBy('name.common')->values();

            $selected = $countries->first(function ($item) use ($country) {

                return $item['cca3'] == $country;

            });

            if ($selected) {

                $countryName = $selected['name']['common'];

            }

        } catch (\Exception $e) {

        }

        /*
        ==========================
        GDP TREND
        ==========================
        */

        $gdpTrend = [];

        try {

            $response = Http::get(

                "https://api.worldbank.org/v2/country/{$country}/indicator/NY.GDP.MKTP.CD?format=json&per_page=10"

            );

            if ($response->successful()) {

                $json = $response->json();

                if (isset($json[1])) {

                    foreach (array_reverse($json[1]) as $row) {

                        if ($row['value'] != null) {

                            $gdpTrend[] = [

                                'year' => $row['date'],

                                'value' => round($row['value'] / 1000000000,2)

                            ];

                        }

                    }

                }

            }

        } catch (\Exception $e) {

        }

        /*
        ==========================
        Inflation Trend
        ==========================
        */

        $inflationTrend = [];

        try {

            $response = Http::get(

                "https://api.worldbank.org/v2/country/{$country}/indicator/FP.CPI.TOTL.ZG?format=json&per_page=10"

            );

            if ($response->successful()) {

                $json = $response->json();

                if (isset($json[1])) {

                    foreach (array_reverse($json[1]) as $row) {

                        if ($row['value'] != null) {

                            $inflationTrend[] = [

                                'year'=>$row['date'],

                                'value'=>round($row['value'],2)

                            ];

                        }

                    }

                }

            }

        } catch (\Exception $e) {

        }

                /*
        ==========================
        Currency Trend (Simulasi)
        ==========================
        */

        $currencyTrend = [];

        try {

            $response = Http::get(
                'https://open.er-api.com/v6/latest/USD'
            );

            if ($response->successful()) {

                $rates = $response->json()['rates'] ?? [];

                $currencyCode = null;

                if (isset($selected['currencies'])) {

                    $currencyCode = array_key_first($selected['currencies']);

                }

                if ($currencyCode && isset($rates[$currencyCode])) {

                    $rate = $rates[$currencyCode];

                    $currencyTrend = [

                        ['day'=>'Mon','value'=>round($rate*0.98,2)],
                        ['day'=>'Tue','value'=>round($rate*1.01,2)],
                        ['day'=>'Wed','value'=>round($rate*1.00,2)],
                        ['day'=>'Thu','value'=>round($rate*1.03,2)],
                        ['day'=>'Fri','value'=>round($rate*0.99,2)],
                        ['day'=>'Sat','value'=>round($rate*1.02,2)],
                        ['day'=>'Sun','value'=>round($rate,2)],

                    ];

                }

            }

        } catch (\Exception $e) {

        }

        /*
        ==========================
        Risk Trend (Simulasi)
        ==========================
        */

        $riskTrend = [

            ['day'=>'Mon','value'=>25],
            ['day'=>'Tue','value'=>35],
            ['day'=>'Wed','value'=>40],
            ['day'=>'Thu','value'=>30],
            ['day'=>'Fri','value'=>50],
            ['day'=>'Sat','value'=>45],
            ['day'=>'Sun','value'=>38],

        ];

        /*
        ==========================
        RETURN VIEW
        ==========================
        */

        return view(
            'visualization.index',
            compact(
                'countries',
                'country',
                'countryName',
                'gdpTrend',
                'inflationTrend',
                'currencyTrend',
                'riskTrend'
            )
        );
    }
}
