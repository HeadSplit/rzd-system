<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'filename',
    ];

    protected $casts = [
        'name' => 'string',
        'group_id' => 'integer'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
