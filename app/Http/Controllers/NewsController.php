<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index()
    {
        $news = [];

        try {

            $response = Http::get(
                'https://gnews.io/api/v4/search?q=logistics&lang=en&token=' . env('GNEWS_API_KEY')
            );

            if ($response->successful()) {
                $news = $response->json()['articles'] ?? [];
            }

        } catch (\Exception $e) {
            $news = [];
        }

        return view('news.index', compact('news'));
    }
}