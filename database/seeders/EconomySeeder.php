<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Economy;
use App\Services\EconomyService;

class EconomySeeder extends Seeder
{
    public function run(): void
    {
        Economy::truncate();

        $service = new EconomyService();

        foreach (Country::all() as $country) {

            $economy = $service->getEconomy($country->cca3);

            Economy::create([

                'country_id' => $country->id,

                'gdp' => $economy['gdp'],

                'inflation' => $economy['inflation'],

                'population' => $economy['population'],

                'export' => $economy['export'],

                'import' => $economy['import'],

            ]);

        }
    }
}