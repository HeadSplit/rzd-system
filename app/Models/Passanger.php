<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passanger extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'surname',
        'patronymic',
        'birth_date',
        'has_patronymic',
        'document',
        'series',
        'number',
        'gender',
        'is_medical',
    ];

    protected $casts = [
        'has_patronymic' => 'boolean',
        'is_medical' => 'boolean',
        'birth_date' => 'date',
    ];
}
