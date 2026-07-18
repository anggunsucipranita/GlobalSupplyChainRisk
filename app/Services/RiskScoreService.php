<?php

namespace App\Services;

use App\Models\Country;
use App\Models\RiskScore;

class RiskScoreService
{
    public function updateRisk(
        Country $country,
        $weatherRisk,
        $economyRisk,
        $currencyRisk,
        $newsRisk,
        $portRisk
    ) {

        $overall = round(

            ($weatherRisk * 0.30) +

            ($economyRisk * 0.20) +

            ($currencyRisk * 0.10) +

            ($newsRisk * 0.25) +

            ($portRisk * 0.15)

        );


        if ($overall <= 30) {

    $level = "Low";

} elseif ($overall <= 60) {

    $level = "Medium";

} else {

    $level = "High";

}


        return RiskScore::updateOrCreate(

            [

                'country_id' => $country->id

            ],

            [

                'weather_risk' => $weatherRisk,

                'economy_risk' => $economyRisk,

                'currency_risk' => $currencyRisk,

                'news_risk' => $newsRisk,

                'port_risk' => $portRisk,

                'overall_risk' => $overall,

                'risk_level' => $level

            ]

        );

    }
}