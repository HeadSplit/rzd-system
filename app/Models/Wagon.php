<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;

class Wagon extends Model
{
    use HasFactory;

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }
}
