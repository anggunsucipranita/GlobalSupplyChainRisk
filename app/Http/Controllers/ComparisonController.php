<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ComparisonController extends Controller
{
    public function index(Request $request)
    {
        $country1 = strtoupper($request->country1 ?? 'IDN');
        $country2 = strtoupper($request->country2 ?? 'DEU');

        /*
        ==========================================
        COUNTRY LIST
        ==========================================
        */

        $countries = collect();

        try {

            $response = Http::timeout(20)->get(
                'https://raw.githubusercontent.com/mledoze/countries/master/countries.json'
            );

            if ($response->successful()) {

                $countries = collect($response->json())
                    ->sortBy('name.common')
                    ->values();

            }

        } catch (\Exception $e) {

            $countries = collect();

        }

        /*
        ==========================================
        COUNTRY 1
        ==========================================
        */

        $data1 = $this->loadCountryData(
            $country1,
            $countries
        );

        /*
        ==========================================
        COUNTRY 2
        ==========================================
        */

        $data2 = $this->loadCountryData(
            $country2,
            $countries
        );

        return view(
            'comparison.index',
            [

                'countries'=>$countries
                    ->pluck('name.common','cca3')
                    ->toArray(),

                'country1'=>$country1,

                'country2'=>$country2,

                'data1'=>$data1,

                'data2'=>$data2

            ]
        );
    }

    /*
    ==========================================
    LOAD COUNTRY DATA
    ==========================================
    */

    private function loadCountryData($countryCode,$countries)
    {

        $country = $countries->first(function($item) use($countryCode){

            return strtoupper($item['cca3']) == $countryCode;

        });

        $countryName = $country['name']['common'] ?? '-';

        $capital = $country['capital'][0] ?? '-';

        $region = $country['region'] ?? '-';

        $population = $country['population'] ?? 0;

        $latitude = $country['latlng'][0] ?? 0;

        $longitude = $country['latlng'][1] ?? 0;

        $currencyCode='-';

        if(isset($country['currencies'])){

            $currencyCode=array_key_first(
                $country['currencies']
            );

        }

        /*
        ============================
        WEATHER
        ============================
        */

        $temperature=null;

        $windSpeed=null;

        $rain=null;

        try{

            $weather=Http::timeout(20)->get(

                'https://api.open-meteo.com/v1/forecast',

                [

                    'latitude'=>$latitude,

                    'longitude'=>$longitude,

                    'current'=>'temperature_2m,wind_speed_10m,rain'

                ]

            );

            if($weather->successful()){

                $current=$weather->json()['current'];

                $temperature=$current['temperature_2m'] ?? 0;

                $windSpeed=$current['wind_speed_10m'] ?? 0;

                $rain=$current['rain'] ?? 0;

            }

        }catch(\Exception $e){

        }
                /*
        ============================
        WORLD BANK
        ============================
        */

        $economy=[

            'gdp'=>null,

            'inflation'=>null,

            'population'=>null

        ];

        $indicators=[

            'gdp'=>'NY.GDP.MKTP.CD',

            'inflation'=>'FP.CPI.TOTL.ZG',

            'population'=>'SP.POP.TOTL'

        ];

        foreach($indicators as $key=>$indicator){

            try{

                $response=Http::timeout(20)->get(

                    "https://api.worldbank.org/v2/country/{$countryCode}/indicator/{$indicator}",

                    [

                        'format'=>'json',

                        'per_page'=>20

                    ]

                );

                if($response->successful()){

                    $json=$response->json();

                    if(isset($json[1])){

                        foreach($json[1] as $item){

                            if(!is_null($item['value'])){

                                $economy[$key]=$item['value'];

                                break;

                            }

                        }

                    }

                }

            }catch(\Exception $e){

            }

        }

        if(!is_null($economy['population'])){

            $population=$economy['population'];

        }

        /*
        ============================
        EXCHANGE RATE
        ============================
        */

        $exchangeRate=null;

        try{

            $exchange=Http::timeout(20)->get(

                'https://open.er-api.com/v6/latest/USD'

            );

            if(

                $exchange->successful() &&

                isset($exchange->json()['rates'][$currencyCode])

            ){

                $exchangeRate=$exchange->json()['rates'][$currencyCode];

            }

        }catch(\Exception $e){

        }

        /*
        ============================
        RISK ENGINE
        ============================
        */

        if($rain<=1){

            $weatherRisk=10;

        }elseif($rain<=5){

            $weatherRisk=35;

        }elseif($rain<=10){

            $weatherRisk=60;

        }else{

            $weatherRisk=90;

        }

        if(is_null($economy['inflation'])){

            $economyRisk=30;

        }elseif($economy['inflation']<=3){

            $economyRisk=15;

        }elseif($economy['inflation']<=6){

            $economyRisk=45;

        }else{

            $economyRisk=80;

        }

        if(is_null($exchangeRate)){

            $currencyRisk=30;

        }elseif($exchangeRate>=1){

            $currencyRisk=20;

        }elseif($exchangeRate>=0.5){

            $currencyRisk=45;

        }else{

            $currencyRisk=75;

        }

        $riskScore=round(

            ($weatherRisk*0.30)+
            ($economyRisk*0.20)+
            ($currencyRisk*0.10)+
            (30*0.25)+
            (30*0.15)

        );

        if($riskScore<=30){

            $riskLevel='Low Risk';

        }elseif($riskScore<=60){

            $riskLevel='Medium Risk';

        }else{

            $riskLevel='High Risk';

        }
                /*
        ==========================================
        RETURN DATA
        ==========================================
        */

        return [

            'country' => $countryName,

            'capital' => $capital,

            'region' => $region,

            'population' => $population,

            'gdp' => $economy['gdp'],

            'inflation' => $economy['inflation'],

            'temperature' => $temperature,

            'wind' => $windSpeed,

            'rain' => $rain,

            'currency' => $currencyCode,

            'exchange_rate' => $exchangeRate,

            'risk_score' => $riskScore,

            'risk_level' => $riskLevel,

            'latitude' => $latitude,

            'longitude' => $longitude

        ];

    }

}