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

        return view('currency.index', compact('currency'));
    }
}