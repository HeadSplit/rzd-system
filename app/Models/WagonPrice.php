<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WagonPrice extends Model
{
    use HasFactory;

    public function seat(): HasOne
    {
        return $this->hasOne(Seat::class);
    }
}
