<?php

namespace App\Http\Controllers;

use App\Services\CountryService;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index()
    {
        $countries = $this->countryService->getCountries();

        return view('countries.index', [

            'countries' => $countries,

            'totalCountries' => $countries->count()

        ]);
    }
}