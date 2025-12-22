<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Route extends Model
{
    public function train(): BelongsTo
    {
        return $this->belongsTo(Train::class);
    }

    public function stations(): BelongsToMany
    {
        return $this->belongsToMany(Station::class, 'route_stations')
            ->withPivot(['order','arrival_time','departure_time'])
            ->orderBy('pivot_order');
    }

    public function wagons(): HasManyThrough
    {
        return $this->hasManyThrough(
            Wagon::class,
            Train::class,
            'id',
            'train_id',
            'train_id',
            'id'
        );
    }
}
