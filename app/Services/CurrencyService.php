<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Country;
use App\Models\Currency;

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

            /*
            ==========================================
            Cari country di database
            ==========================================
            */

            $dbCountry = Country::where(
                'cca3',
                $country['cca3']
            )->first();

            if (!$dbCountry) {

                return [

                    "code" => $currencyCode,

                    "rate" => "-"

                ];

            }

            /*
            ==========================================
            Cek cache database
            ==========================================
            */

            $cache = Currency::where(
                'country_id',
                $dbCountry->id
            )->first();

            if ($cache) {

                return [

                    "code" => $cache->currency_code,

                    "rate" => $cache->exchange_rate

                ];

            }

            /*
            ==========================================
            Ambil dari API
            ==========================================
            */

            $response = Http::timeout(20)->get(
                "https://open.er-api.com/v6/latest/USD"
            );

            if (!$response->successful()) {

                return [

                    "code" => $currencyCode,

                    "rate" => "-"

                ];

            }

            $rates = $response->json()['rates'];

            $rate = $rates[$currencyCode] ?? "-";

            /*
            ==========================================
            Simpan ke database
            ==========================================
            */

            Currency::create([

                "country_id" => $dbCountry->id,

                "currency_code" => $currencyCode,

                "exchange_rate" => $rate,

                "updated_at_api" => now()

            ]);

            return [

                "code" => $currencyCode,

                "rate" => $rate

            ];

        } catch (\Exception $e) {

            return [

                "code" => "-",

                "rate" => "-"

            ];

        }
    }
}