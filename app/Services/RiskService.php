<?php

namespace App\Services;

class RiskService
{
    public function calculate($weather, $economy, $currency, $news, $ports)
    {
        $weatherRisk = 0;
        $inflationRisk = 0;
        $currencyRisk = 0;
        $newsRisk = 0;
        $portRisk = 0;

        /*
        ==========================================
        WEATHER
        ==========================================
        */

        if (!empty($weather)) {

            if (($weather['wind'] ?? 0) > 40)
                $weatherRisk = 30;

            elseif (($weather['wind'] ?? 0) > 20)
                $weatherRisk = 15;

            if (($weather['rain'] ?? 0) > 20)
                $weatherRisk += 10;

        }

        /*
        ==========================================
        INFLATION
        ==========================================
        */

        if (is_numeric($economy['inflation'] ?? null)) {

            if ($economy['inflation'] > 8)
                $inflationRisk = 20;

            elseif ($economy['inflation'] > 4)
                $inflationRisk = 10;

        }

        /*
        ==========================================
        CURRENCY
        ==========================================
        */

        if (is_numeric($currency['rate'] ?? null)) {

            if ($currency['rate'] > 15000)
                $currencyRisk = 10;

            else
                $currencyRisk = 5;

        }

        /*
        ==========================================
        NEWS
        ==========================================
        */

        $negative = 0;

        foreach ($news as $article) {

            $title = strtolower($article['title'] ?? '');

            foreach ([
                'war',
                'crisis',
                'inflation',
                'delay',
                'disaster',
                'conflict',
                'attack'
            ] as $word) {

                if (str_contains($title, $word))
                    $negative++;

            }

        }

        $newsRisk = min($negative * 5, 25);

        /*
        ==========================================
        PORT
        ==========================================
        */

        if (count($ports) == 0)
            $portRisk = 15;

        else
            $portRisk = 5;

        /*
        ==========================================
        TOTAL
        ==========================================
        */

        $score =
            $weatherRisk +
            $inflationRisk +
            $currencyRisk +
            $newsRisk +
            $portRisk;

        if ($score < 35) {

            $status = "Low";

            $recommendation = "Import can continue safely.";

        }

        elseif ($score < 70) {

            $status = "Medium";

            $recommendation = "Import can continue with monitoring.";

        }

        else {

            $status = "High";

            $recommendation = "Delay shipment until conditions improve.";

        }

        return [

            "score" => $score,

            "status" => $status,

            "recommendation" => $recommendation,

            "weatherRisk" => $weatherRisk,

            "inflationRisk" => $inflationRisk,

            "currencyRisk" => $currencyRisk,

            "newsRisk" => $newsRisk,

            "portRisk" => $portRisk

        ];
    }
}