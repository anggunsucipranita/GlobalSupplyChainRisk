<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\SentimentService;

class NewsController extends Controller
{
public function index()
{
    $news = [];

    $sentimentService = new SentimentService();

    $keyword = request()->get('search', 'logistics');

    try {

        $response = Http::get(
            'https://gnews.io/api/v4/search',
            [
                'q' => $keyword,
                'lang' => 'en',
                'max' => 10,
                'sortby' => 'publishedAt',
                'token' => env('GNEWS_API_KEY')
            ]
        );

        if ($response->successful()) {

            $news = $response->json()['articles'] ?? [];

            foreach ($news as &$article) {

                $article['analysis'] = $sentimentService->analyze(

                    ($article['title'] ?? '') .
                    ' ' .
                    ($article['description'] ?? '')

                );

            }

        }

    } catch (\Exception $e) {

        $news = [];

    }

    return view('news.index', [
        'news' => $news,
        'keyword' => $keyword
    ]);
}
}