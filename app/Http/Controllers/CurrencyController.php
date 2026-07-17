<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    public function index()
    {
        try {

            $response = Http::timeout(10)
                ->get('https://open.er-api.com/v6/latest/USD');

            if ($response->successful()) {

                $currency = $response->json();

            } else {

                $currency = [];

            }

        } catch (\Exception $e) {

            $currency = [];

        }

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

        return view(
            'currency.index',
            compact(
                'currency',
                'chartLabels',
                'chartRates'
            )
        );
    }
}