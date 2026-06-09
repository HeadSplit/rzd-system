<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function seats():BelongsToMany
    {
        return $this->belongsToMany(Seat::class, 'ticket_seat');
    }
}
