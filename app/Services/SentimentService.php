<?php

namespace App\Services;

class SentimentService
{
    protected $positiveWords = [

        'growth',
        'increase',
        'profit',
        'stable',
        'improve',
        'success',
        'good',
        'positive',
        'recover',
        'strong',
        'efficient',
        'opportunity',
        'innovation',
        'development'

    ];

    protected $negativeWords = [

        'war',
        'crisis',
        'inflation',
        'delay',
        'disaster',
        'conflict',
        'loss',
        'decline',
        'drop',
        'risk',
        'earthquake',
        'storm',
        'flood',
        'recession',
        'problem',
        'strike'

    ];

    public function analyze($text)
    {

        $text = strtolower(strip_tags($text));

        $words = preg_split('/\s+/', $text);

        $positive = 0;

        $negative = 0;

        foreach ($words as $word) {

            $word = preg_replace('/[^a-z]/', '', $word);

            if (in_array($word, $this->positiveWords)) {

                $positive++;

            }

            if (in_array($word, $this->negativeWords)) {

                $negative++;

            }

        }

        if ($positive > $negative) {

            $sentiment = "Positive";

        } elseif ($negative > $positive) {

            $sentiment = "Negative";

        } else {

            $sentiment = "Neutral";

        }

        return [

            'positive' => $positive,

            'negative' => $negative,

            'sentiment' => $sentiment

        ];

    }
}