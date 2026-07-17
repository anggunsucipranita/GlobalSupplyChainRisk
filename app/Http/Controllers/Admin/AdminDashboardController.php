<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Http;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total User
        $totalUsers = User::count();

        // Total Favorite
        $totalWatchlists = Watchlist::count();

        // Total Countries
        $totalCountries = 0;

        try {

            $response = Http::get(
                'https://raw.githubusercontent.com/mledoze/countries/master/countries.json'
            );

            if ($response->successful()) {

                $totalCountries = count($response->json());

            }

        } catch (\Exception $e) {

        }

        // Dummy dulu (nanti kita ganti saat CRUD selesai)
        $totalPorts = 0;
        $totalArticles = 0;

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalWatchlists',
            'totalCountries',
            'totalPorts',
            'totalArticles'
        ));
    }
}