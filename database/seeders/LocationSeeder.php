<?php

namespace Database\Seeders;

use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $locations = [];

        /*
        ===================================
        USER 2 - LUBUK PAKAM
        ===================================
        */

        $lat = 3.5400;
        $lng = 98.8750;

        for ($i = 0; $i < 30; $i++) {

            $lat += rand(-5,5) * 0.0002;
            $lng += rand(-5,5) * 0.0002;

            $locations[] = [
                'user_id' => 2,
                'latitude' => $lat,
                'longitude' => $lng,
                'recorded_at' => $now->copy()->subMinutes((30 - $i) * 15),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        /*
        ===================================
        USER 3 - TANJUNG MORAWA
        ===================================
        */

        $lat = 3.5200;
        $lng = 98.7500;

        for ($i = 0; $i < 30; $i++) {

            $lat += rand(-4,4) * 0.00025;
            $lng += rand(-4,4) * 0.00025;

            $locations[] = [
                'user_id' => 3,
                'latitude' => $lat,
                'longitude' => $lng,
                'recorded_at' => $now->copy()->subMinutes((30 - $i) * 15),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        /*
        ===================================
        USER 4 - PERCUT SEI TUAN
        ===================================
        */

        $lat = 3.6500;
        $lng = 98.7800;

        for ($i = 0; $i < 30; $i++) {

            $lat += rand(-3,3) * 0.0003;
            $lng += rand(-3,3) * 0.0003;

            $locations[] = [
                'user_id' => 4,
                'latitude' => $lat,
                'longitude' => $lng,
                'recorded_at' => $now->copy()->subMinutes((30 - $i) * 15),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        /*
        ===================================
        USER 5 - PANCUR BATU
        ===================================
        */

        $lat = 3.4500;
        $lng = 98.6000;

        for ($i = 0; $i < 30; $i++) {

            $lat += rand(-5,5) * 0.00025;
            $lng += rand(-5,5) * 0.00025;

            $locations[] = [
                'user_id' => 5,
                'latitude' => $lat,
                'longitude' => $lng,
                'recorded_at' => $now->copy()->subMinutes((30 - $i) * 15),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        /*
        ===================================
        SIMPAN DATA
        ===================================
        */

        Location::insert($locations);
    }
}