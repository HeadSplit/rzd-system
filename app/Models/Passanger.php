<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Passanger extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'surname',
        'patronymic',
        'has_patronymic',
        'birth_date',
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

    const DOCUMENT_TYPES = [
        'passport_rf'      => 'Паспорт РФ',
        'foreign_passport' => 'Заграничный паспорт',
        'foreign_doc'      => 'Иностранный документ',
        'residence_permit' => 'Вид на жительство в РФ',
        'passport_ussr'    => 'Паспорт СССР',
    ];

    const GENDERS = [
        'male'   => 'Мужской',
        'female' => 'Женский',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function getDocumentTypeLabelAttribute()
    {
        return self::DOCUMENT_TYPES[$this->document] ?? $this->document;
    }

    public function getBirthDateFormattedAttribute()
    {
        return $this->birth_date
            ? $this->birth_date->format('d.m.Y')
            : null;
    }

    public function getGenderLabelAttribute()
    {
        return self::GENDERS[$this->gender] ?? $this->gender;
    }
}
