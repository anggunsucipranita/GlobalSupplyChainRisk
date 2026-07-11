<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyService
{
    public function getCurrency($country)
    {
        try {

            if (
                empty($country) ||
                !isset($country['currencies'])
            ) {

                return null;

            }

            $currencyCode = array_key_first(
                $country['currencies']
            );

            $response = Http::get(
                "https://open.er-api.com/v6/latest/USD"
            );

            if (!$response->successful()) {

                return [

                    "code" => $currencyCode,
                    "rate" => "-"

                ];

            }

            $rates = $response->json()['rates'];

            return [

                "code" => $currencyCode,

                "rate" => $rates[$currencyCode] ?? "-"

            ];

        } catch (\Exception $e) {

            return [

                "code" => "-",
                "rate" => "-"

            ];

        }
    }
}