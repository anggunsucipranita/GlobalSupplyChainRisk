<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Port;
use App\Services\PortService;

class PortSeeder extends Seeder
{
    public function run(): void
    {

        Port::truncate();

        $service = new PortService();

        $ports = $service->getPorts();


        foreach ($ports as $port) {


Port::create([

    'name' => $port['name'] ?? '-',

    'country' => $port['country'] ?? '-',

    'city' => $port['city'] ?? ($port['name'] ?? null),

    'latitude' => $port['lat'] ?? null,

    'longitude' => $port['lng'] ?? null,

    'size' => $port['size'] ?? null,

    'status' => 'Active',

]);
        }

    }
}