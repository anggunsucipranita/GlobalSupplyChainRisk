<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EconomyService
{
    public function getEconomy($countryCode)
    {
        $economy = [

            'gdp' => null,
            'inflation' => null,
            'population' => null,
            'export' => null,
            'import' => null,

        ];

        $indicators = [

            'gdp' => 'NY.GDP.MKTP.CD',

            'inflation' => 'FP.CPI.TOTL.ZG',

            'population' => 'SP.POP.TOTL',

            'export' => 'NE.EXP.GNFS.CD',

            'import' => 'NE.IMP.GNFS.CD',

        ];

        foreach ($indicators as $key => $indicator) {

            try {

                $response = Http::timeout(20)->get(

                    "https://api.worldbank.org/v2/country/{$countryCode}/indicator/{$indicator}",

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

        return $economy;
    }
}