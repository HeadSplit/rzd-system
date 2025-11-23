<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Seat extends Model
{
    use HasFactory;

    public function wagonprice(): HasOne
    {
        return $this->hasOne(Wagonprice::class);
    }
}
