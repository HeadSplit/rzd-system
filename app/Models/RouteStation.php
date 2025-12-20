<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteStation extends Model
{
    protected $fillable = [
        'route_id',
        'station_id',
        'order',
        'arrival_time',
        'departure_time',
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }
}

