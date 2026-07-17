<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function index()
    {
        $watchlists = Watchlist::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('watchlists.index', compact('watchlists'));
    }

    public function store(Request $request)
    {
        Watchlist::firstOrCreate(

            [
                'user_id' => Auth::id(),
                'country_code' => $request->country_code,
            ],

            [
                'country_name' => $request->country_name,
            ]

        );

        return redirect()
            ->back()
            ->with('success', 'Country added to Favorite Monitoring.');
    }

    public function destroy($id)
    {
        $watchlist = Watchlist::where('user_id', Auth::id())
            ->findOrFail($id);

        $watchlist->delete();

        return redirect()
            ->back()
            ->with('success', 'Country removed from Favorite Monitoring.');
    }
}