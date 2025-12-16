<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Station;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StationSeeder::class,
            TrainSeeder::class,
            WagonSeeder::class,
            WagonPricesSeeder::class,
            SeatSeeder::class,
        ]);
    }
}
