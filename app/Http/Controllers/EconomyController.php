<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Country;
use App\Models\Economy;

class EconomyController extends Controller
{
    public function index(Request $request)
    {

        $country = strtoupper(
            $request->country ?? 'IDN'
        );


        /*
        ======================================================
        COUNTRY LIST
        ======================================================
        */

        try {

            $response = Http::timeout(20)->get(
                'https://raw.githubusercontent.com/mledoze/countries/master/countries.json'
            );


            if ($response->successful()) {

                $countries = collect($response->json())
                    ->sortBy('name.common')
                    ->values();

            } else {

                $countries = collect();

            }


        } catch (\Exception $e) {

            $countries = collect();

        }



        /*
        ======================================================
        ECONOMY CACHE DATABASE
        ======================================================
        */


        $economy = null;


        $countryData = Country::where(
            'cca3',
            $country
        )->first();



        if ($countryData) {


            $economy = Economy::where(
                'country_id',
                $countryData->id
            )->first();


        }



        /*
        ======================================================
        DEFAULT VALUE
        ======================================================
        */


        if (!$economy) {


            $economy = (object)[

                'gdp' => null,

                'inflation' => null,

                'population' => null,

                'export' => null,

                'import' => null,

            ];


        }



        return view('economy.index',[


            'economy' => $economy,


            'country' => $country,


            'countries' => $countries,


            'countryData' => $countryData


        ]);


    }
}