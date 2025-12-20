<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Train extends Model
{
    use HasFactory;

    public function routes(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

}
