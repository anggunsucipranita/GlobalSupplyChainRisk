<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsCache;

class NewsApiController extends Controller
{
    public function index()
    {
        return response()->json(
            NewsCache::latest('published_at')
                ->take(20)
                ->get()
        );
    }
}