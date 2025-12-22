<?php

namespace App\Services;

use App\Models\Wagon;

class SeatPriceService
{
    public static function generate(Wagon $wagon): int
    {
        return rand(
            $wagon->wagonprice->min_price,
            $wagon->wagonprice->max_price
        );
    }
}
