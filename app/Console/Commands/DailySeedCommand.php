<?php

namespace App\Console\Commands;

use App\Services\WagonFeaturesService;
use Database\Seeders\RouteStationSeeder;
use Database\Seeders\SeatSeeder;
use Database\Seeders\StationSeeder;
use Database\Seeders\TrainSeeder;
use Database\Seeders\WagonPricesSeeder;
use Database\Seeders\WagonSeeder;
use Illuminate\Console\Command;

class DailySeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run seeders for daily update';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $wagonFeaturesService = app(WagonFeaturesService::class);

        $this->info('Starting daily seed update...');

        (new StationSeeder())->run();
        (new TrainSeeder())->run();
        (new WagonSeeder())->run();
        (new WagonPricesSeeder())->run();
        (new SeatSeeder(app(WagonFeaturesService::class)))->run();
        (new RouteStationSeeder())->run();

        $this->info('Daily seed update finished.');
    }
}
