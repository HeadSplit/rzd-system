<?php

namespace Database\Seeders;

use App\Models\Train;
use App\Models\Wagon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Train::factory()
            ->count(30)
            ->create();
    }
}
