<?php

namespace Database\Seeders;

use App\Models\Seat;
use App\Models\Wagon;
use App\Models\WagonPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WagonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wagon::factory()
            ->count(150)
            ->has(WagonPrice::factory())
            ->create();
    }
}
