<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsService
{
    protected $apiKey = "2dfb0f4f9eefaa9d92cfaad527942ccb";

    public function getNews($countryName)
    {
        try {

            $response = Http::get(
                "https://gnews.io/api/v4/search",
                [

                    "q" => $countryName . " logistics OR trade OR shipping",

                    "lang" => "en",

                    "max" => 5,

                    "apikey" => $this->apiKey

                ]
            );

            if (!$response->successful()) {

                return [];

            }

            return $response->json()['articles'] ?? [];

        } catch (\Exception $e) {

            return [];

        }
    }
}