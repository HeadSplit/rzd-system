<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Train extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'number',
      'start_station_id',
      'end_station_id',
    ];

    public function routes(): HasOne
    {
        return $this->HasOne(Route::class);
    }

    public function wagons(): HasMany
    {
        return $this->HasMany(Wagon::class);
    }
}
