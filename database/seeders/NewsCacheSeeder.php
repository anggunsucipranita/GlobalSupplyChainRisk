<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\NewsCache;

class NewsCacheSeeder extends Seeder
{
    public function run(): void
    {
        NewsCache::truncate();

        $apiKey = env('GNEWS_API_KEY');

        $response = Http::get(
            'https://gnews.io/api/v4/search',
            [
                'q' => 'global supply chain OR logistics OR shipping OR economy',
                'lang' => 'en',
                'max' => 10,
                'apikey' => $apiKey,
            ]
        );

        if (!$response->successful()) {
            return;
        }

        foreach ($response->json()['articles'] as $article) {

            NewsCache::create([

                'title' => $article['title'] ?? '',

                'description' => $article['description'] ?? '',

                'image' => $article['image'] ?? '',

                'url' => $article['url'] ?? '',

                'source' => $article['source']['name'] ?? '',

                'published_at' => $article['publishedAt'] ?? now(),

                'sentiment' => 'Neutral',

                'positive' => 0,

                'negative' => 0,

            ]);

        }
    }
}