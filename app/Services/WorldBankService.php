<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WorldBankService
{
    public function getEconomy($countryCode)
    {
        return [

            "gdp" => $this->indicator(
                $countryCode,
                "NY.GDP.MKTP.CD"
            ),

            "inflation" => $this->indicator(
                $countryCode,
                "FP.CPI.TOTL.ZG"
            ),

            "population" => $this->indicator(
                $countryCode,
                "SP.POP.TOTL"
            )

        ];
    }

    private function indicator($country,$indicator)
    {
        try{

            $url="https://api.worldbank.org/v2/country/".$country.
                "/indicator/".$indicator.
                "?format=json&per_page=100";

            $response=Http::get($url);

            if(!$response->successful()){

                return "-";

            }

            $json=$response->json();

            if(!isset($json[1])){

                return "-";

            }

            foreach($json[1] as $row){

                if($row['value']!=null){

                    return $row['value'];

                }

            }

            return "-";

        }catch(\Exception $e){

            return "-";

        }
    }
}