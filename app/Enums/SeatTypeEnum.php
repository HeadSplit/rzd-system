<?php

namespace App\Enums;

Enum SeatTypeEnum: string
{
    case basic = "default";
    case normal = "normal";
    case business = "business";
    case firstClass = "firstClass";
    case suite = "suite";
    case premium = "premium";
    case meetingRoom = "meetingRoom";
    case busy = "busy";
    case invalid = "invalid";

    public function label(): string
    {
        return match ($this) {
            self::basic => 'Базовое место',
            self::normal => 'Обычное место',
            self::business => 'Бизнес-класс',
            self::firstClass => 'Первый класс',
            self::suite => 'Люкс',
            self::premium => 'Премиум',
            self::meetingRoom => 'Переговорная',
            self::busy => 'Занято',
            self::invalid => 'Недоступно',
        };
    }

    public function css(): string
    {
        return match ($this) {
            self::meetingRoom => 'seat--meeting',
            self::suite => 'seat--suite',
            self::premium => 'seat--premium',
            default => 'seat--default',
        };
    }
}
