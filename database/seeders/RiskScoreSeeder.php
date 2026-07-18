<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\RiskScore;

class RiskScoreSeeder extends Seeder
{
    public function run(): void
    {
        RiskScore::truncate();

        $countries = Country::all();

        foreach ($countries as $country) {

            $weather = rand(20,80);

            $economy = rand(20,80);

            $currency = rand(20,80);

            $news = rand(20,80);

            $port = rand(20,80);


            $overall = round(

                ($weather * 0.25) +

                ($economy * 0.20) +

                ($currency * 0.15) +

                ($news * 0.25) +

                ($port * 0.15)

            );


            if ($overall >= 70) {

                $level = 'High';

            } elseif ($overall >= 40) {

                $level = 'Medium';

            } else {

                $level = 'Low';

            }


            RiskScore::create([

                'country_id' => $country->id,

                'weather_risk' => $weather,

                'economy_risk' => $economy,

                'currency_risk' => $currency,

                'news_risk' => $news,

                'port_risk' => $port,

                'overall_risk' => $overall,

                'risk_level' => $level

            ]);

        }
    }
}