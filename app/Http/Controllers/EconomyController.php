<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class EconomyController extends Controller
{
    public function index()
    {
        $country = request('country', 'IDN');

        try {

    $response = Http::get(
        'https://raw.githubusercontent.com/mledoze/countries/master/countries.json'
    );

    $countries = collect($response->json())
        ->sortBy('name.common')
        ->values();

    } catch (\Exception $e) {

    $countries = collect();

    }

        $indicators = [
            "gdp" => "NY.GDP.MKTP.CD",
            "inflation" => "FP.CPI.TOTL.ZG",
            "population" => "SP.POP.TOTL",
            "export" => "NE.EXP.GNFS.CD",
            "import" => "NE.IMP.GNFS.CD"
        ];

        $economy = [];

        foreach ($indicators as $key => $indicator) {

            try {

                $response = Http::timeout(15)->get(
                    "https://api.worldbank.org/v2/country/{$country}/indicator/{$indicator}?format=json&per_page=10"
                );

                $economy[$key] = null;

                if ($response->successful()) {

                    $data = $response->json();

                    if (isset($data[1])) {

                        foreach ($data[1] as $item) {

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

        return view('economy.index', compact(
        'economy',
        'country',
        'countries'
            ));
    }
}