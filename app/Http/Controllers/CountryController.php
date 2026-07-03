<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    public function index()
    {
        try {

            $response = Http::get('https://raw.githubusercontent.com/mledoze/countries/master/countries.json');

            if ($response->successful()) {

                $countries = $response->json();

            } else {

                $countries = [];

            }

        } catch (\Exception $e) {

            $countries = [];

        }

        return view('countries.index', [
            'countries' => $countries,
            'totalCountries' => count($countries)
        ]);
    }
}