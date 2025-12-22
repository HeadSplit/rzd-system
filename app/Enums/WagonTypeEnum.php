<?php

namespace App\Enums;

Enum WagonTypeEnum: string
{
    case default = 'default';
    case doubleDecker = "doubleDecker";
    case branded = "branded";

    public function label(): string
    {
        return match($this) {
            self::default => 'Обычный',
            self::doubleDecker => 'Двухэтажный',
            self::branded => 'Фирменный',
        };
    }
}
