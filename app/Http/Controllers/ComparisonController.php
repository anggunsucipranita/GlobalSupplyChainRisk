<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ComparisonController extends Controller
{
    public function index()
    {
        $country1 = request('country1', 'IDN');
        $country2 = request('country2', 'DEU');

        $countries = [
            'IDN' => 'Indonesia',
            'DEU' => 'Germany',
            'CHN' => 'China',
            'AUS' => 'Australia'
        ];

        $data1 = $this->getEconomy($country1);
        $data2 = $this->getEconomy($country2);

        return view('comparison.index', compact(
            'country1',
            'country2',
            'countries',
            'data1',
            'data2'
        ));
    }

    private function getEconomy($country)
    {
        $indicators = [
            "gdp" => "NY.GDP.MKTP.CD",
            "inflation" => "FP.CPI.TOTL.ZG",
            "population" => "SP.POP.TOTL"
        ];

        $result = [];

        foreach ($indicators as $key => $indicator) {

            try {

                $response = Http::get(
                    "https://api.worldbank.org/v2/country/$country/indicator/$indicator?format=json&per_page=10"
                );

                $result[$key] = null;

                if ($response->successful()) {

                    $json = $response->json();

                    if (isset($json[1])) {

                        foreach ($json[1] as $item) {

                            if ($item['value'] != null) {

                                $result[$key] = $item['value'];
                                break;

                            }

                        }

                    }

                }

            } catch (\Exception $e) {

                $result[$key] = null;

            }

        }

        return $result;
    }
}