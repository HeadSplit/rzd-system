<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'ticket_id',
        'description',
        'correct_answers',
        'user_answers',
        'status',
    ];

    protected $casts = [
        'correct_answers' => 'array',
        'user_answers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
