<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Currency;

class CurrencyApiController extends Controller
{
    public function index()
    {
        return response()->json(
            Currency::with('country')->get()
        );
    }
}