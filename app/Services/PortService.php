<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PortService
{
    public function getPorts($country = null)
    {
        try {

            $response = Http::get(
                'https://pocketworld.org/api/ports'
            );

            if (!$response->successful()) {

                return [];

            }

            $ports = $response->json()['ports'] ?? [];

            if (!$country) {

                return $ports;

            }

            return collect($ports)

                ->filter(function ($port) use ($country) {

                    return isset($port['country']) &&
                           strtolower($port['country']) ==
                           strtolower($country);

                })

                ->values()

                ->toArray();

        } catch (\Exception $e) {

            return [];

        }
    }
}