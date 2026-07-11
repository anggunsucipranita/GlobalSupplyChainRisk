<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PortController extends Controller
{
    public function index(Request $request)
    {
        $ports = [];

        try {

            $response = Http::get('https://pocketworld.org/api/ports');

if ($response->successful()) {

    $ports = $response->json()['ports'];

}



        } catch (\Exception $e) {

            $ports = [];

        }

        $search = $request->search;

        if ($search) {

            $ports = array_filter($ports, function ($port) use ($search) {

                return
                    stripos($port['name'] ?? '', $search) !== false ||
                    stripos($port['country'] ?? '', $search) !== false;

            });

        }

        return view('ports.index', compact('ports', 'search'));
    }
}