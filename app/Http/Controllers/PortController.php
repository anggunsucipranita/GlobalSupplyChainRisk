<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Port;

class PortController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->search;


        $ports = Port::query();


        if ($search) {

            $ports->where('name', 'like', "%$search%")
                  ->orWhere('country', 'like', "%$search%")
                  ->orWhere('city', 'like', "%$search%");

        }


        $ports = $ports->get();


        return view('ports.index', compact(
            'ports',
            'search'
        ));

    }
}