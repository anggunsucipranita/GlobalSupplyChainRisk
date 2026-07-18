<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Country;
use App\Models\WeatherCache;
use Carbon\Carbon;

class WeatherService
{
    public function getWeather($country)
    {
        try {

            /*
            ========================================
            AMBIL COUNTRY DARI DATABASE
            ========================================
            */

            $dbCountry = Country::where('cca3', $country['cca3'])->first();

            if (!$dbCountry) {

                return null;

            }


            /*
            ========================================
            CEK WEATHER CACHE
            ========================================
            */

            $cache = WeatherCache::where(
                'country_id',
                $dbCountry->id
            )->first();


            if (

                $cache &&

                $cache->last_updated &&

                $cache->last_updated->diffInMinutes(now()) < 60

            ) {
                \Log::info('Weather loaded from CACHE');

                return [

                    "temperature"=>$cache->temperature,

                    "wind"=>$cache->wind_speed,

                    "rain"=>$cache->rain,

                    "weather"=>$cache->weather,

                    "weather_code"=>0

                ];

            }


            /*
            ========================================
            API OPEN METEO
            ========================================
            */

            if (

                empty($country) ||

                !isset($country['latlng']) ||

                count($country['latlng']) < 2

            ) {

                return null;

            }


            $lat = $country['latlng'][0];

            $lon = $country['latlng'][1];


            $response = Http::get(

                "https://api.open-meteo.com/v1/forecast",

                [

                    "latitude"=>$lat,

                    "longitude"=>$lon,

                    "current"=>[

                        "temperature_2m",

                        "wind_speed_10m",

                        "rain",

                        "weather_code"

                    ]

                ]

            );


            if(!$response->successful()){

                return null;

            }


            $current = $response->json()['current'];


            $weatherName = $this->weatherText(

                $current['weather_code'] ?? 0

            );


            /*
            ========================================
            UPDATE CACHE
            ========================================
            */
            \Log::info('Weather loaded from API');

            WeatherCache::updateOrCreate(

                [

                    'country_id'=>$dbCountry->id

                ],

                [

                    'temperature'=>$current['temperature_2m'] ?? 0,

                    'wind_speed'=>$current['wind_speed_10m'] ?? 0,

                    'rain'=>$current['rain'] ?? 0,

                    'humidity'=>0,

                    'weather'=>$weatherName,

                    'last_updated'=>Carbon::now()

                ]

            );


            return [

                "temperature"=>$current['temperature_2m'] ?? 0,

                "wind"=>$current['wind_speed_10m'] ?? 0,

                "rain"=>$current['rain'] ?? 0,

                "weather_code"=>$current['weather_code'] ?? 0,

                "weather"=>$weatherName

            ];

        }

        catch(\Exception $e){

            return null;

        }

    }


    private function weatherText($code)
    {

        return match($code){

            0=>"Clear Sky",

            1,2=>"Partly Cloudy",

            3=>"Cloudy",

            45,48=>"Fog",

            51,53,55=>"Drizzle",

            61,63,65=>"Rain",

            71,73,75=>"Snow",

            80,81,82=>"Heavy Rain",

            95=>"Thunderstorm",

            default=>"Unknown"

        };

    }

}