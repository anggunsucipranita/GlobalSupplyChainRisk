<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Watchlist;
use App\Models\Port;
use App\Models\Article;
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

        // Ambil jumlah data dari database
        $totalPorts = Port::count();
        $totalArticles = Article::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalWatchlists',
            'totalCountries',
            'totalPorts',
            'totalArticles'
        ));
    }
}