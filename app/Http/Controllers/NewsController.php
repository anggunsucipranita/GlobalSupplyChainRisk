<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\NewsCache;
use App\Services\SentimentService;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search', 'logistics');

        $sentimentService = new SentimentService();


        /*
        |--------------------------------------------------------------------------
        | CARI DARI DATABASE NEWS CACHE
        |--------------------------------------------------------------------------
        */

        $news = NewsCache::where('title', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->orWhere('source', 'like', "%{$keyword}%")
            ->orderBy('published_at', 'desc')
            ->paginate(10);



        /*
        |--------------------------------------------------------------------------
        | JIKA DATA TIDAK ADA, AMBIL DARI GNEWS API
        |--------------------------------------------------------------------------
        */

        if ($news->total() == 0) {


            try {


                $response = Http::get(
                    'https://gnews.io/api/v4/search',
                    [

                        'q' => $keyword,

                        'lang' => 'en',

                        'max' => 10,

                        'sortby' => 'publishedAt',

                        'apikey' => env('GNEWS_API_KEY')

                    ]
                );



                if ($response->successful()) {


                    $articles = $response->json()['articles'] ?? [];



                    foreach ($articles as $article) {


                        $analysis = $sentimentService->analyze(

                            ($article['title'] ?? '') .
                            ' ' .
                            ($article['description'] ?? '')

                        );



                        NewsCache::updateOrCreate(

                            [

                                'url' => $article['url'] ?? ''

                            ],

                            [

                                'title' => $article['title'] ?? '',

                                'description' => $article['description'] ?? '',

                                'image' => $article['image'] ?? '',

                                'source' => $article['source']['name'] ?? '',

                                'published_at' => $article['publishedAt'] ?? now(),

                                'sentiment' => $analysis['sentiment'] ?? 'Neutral',

                                'positive' => $analysis['positive'] ?? 0,

                                'negative' => $analysis['negative'] ?? 0,

                            ]

                        );

                    }


                    // ambil ulang dari database setelah disimpan

                    $news = NewsCache::where('title', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%")
                        ->orWhere('source', 'like', "%{$keyword}%")
                        ->orderBy('published_at', 'desc')
                        ->paginate(10);


                }


            } catch (\Exception $e) {


                $news = NewsCache::latest()
                    ->paginate(10);


            }


        }



        return view('news.index',[

            'news' => $news,

            'keyword' => $keyword

        ]);
    }
}