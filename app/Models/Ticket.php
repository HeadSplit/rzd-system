<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'passanger_id',
        'seat_id',
        'from',
        'from_date',
        'to',
        'to_date',
        'adult_person',
        'child_with_place',
        'child_without_place',
        'place_for_invalid',
        'place_for_family',
        'pets',
        'car',
        'motorcycle',
    ];

    protected $casts = [
        'from_date' => 'datetime',
        'to_date' => 'datetime',
    ];

    public function seats():BelongsToMany
    {
        return $this->belongsToMany(Seat::class, 'ticket_seat');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function passanger(): BelongsTo
    {
        return $this->belongsTo(Passanger::class);
    }
    public function fromStation()
    {
        return $this->belongsTo(Station::class, 'from');
    }

    public function toStation()
    {
        return $this->belongsTo(Station::class, 'to');
    }
}
