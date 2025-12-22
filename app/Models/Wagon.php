<?php

namespace App\Models;

use App\Enums\WagonServiceClassEnum;
use App\Enums\WagonTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Wagon extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'description',
      'seats_total',
      'seats_available',
      'service_class',
        'features'
    ];
    protected $casts = [
        'features' => 'array',
        'service_class' => WagonServiceClassEnum::class,
        'type' => WagonTypeEnum::class,
    ];
    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    public function wagonprice(): HasOne
    {
       return $this->hasOne(WagonPrice::class);
    }

    public function train(): BelongsTo
    {
        return $this->belongsTo(Train::class);
    }

    public function getFeaturesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function getAvailableSeatsCountAttribute(): int
    {
        return $this->seats->where('is_available', true)->count();
    }
}
