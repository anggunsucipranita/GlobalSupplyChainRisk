<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        /*
        ==========================================
        COUNTRY LIST
        ==========================================
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
        ==========================================
        CURRENCY API
        ==========================================
        */

        $currency = [];

        try {

            $response = Http::timeout(15)
                ->get('https://open.er-api.com/v6/latest/USD');

            if ($response->successful()) {

                $currency = $response->json();

            }

        } catch (\Exception $e) {

            $currency = [];

        }

        /*
        ==========================================
        SELECTED COUNTRY CURRENCY
        ==========================================
        */

        $currencyCode = '-';

        $exchangeRate = null;

        if ($countryData && isset($countryData['currencies'])) {

            $currencyCode = array_key_first($countryData['currencies']);

            $exchangeRate = $currency['rates'][$currencyCode] ?? null;

        }

        /*
        ==========================================
        CHART
        ==========================================
        */

        $chartLabels = [
            'USD',
            'EUR',
            'GBP',
            'JPY',
            'AUD',
            'IDR'
        ];

        $chartRates = [

            $currency['rates']['USD'] ?? 0,

            $currency['rates']['EUR'] ?? 0,

            $currency['rates']['GBP'] ?? 0,

            $currency['rates']['JPY'] ?? 0,

            $currency['rates']['AUD'] ?? 0,

            $currency['rates']['IDR'] ?? 0,

        ];

        return view('currency.index', [

            'currency' => $currency,

            'countries' => $countries,

            'selectedCountry' => $selectedCountry,

            'countryData' => $countryData,

            'currencyCode' => $currencyCode,

            'exchangeRate' => $exchangeRate,

            'chartLabels' => $chartLabels,

            'chartRates' => $chartRates,

        ]);
    }
}