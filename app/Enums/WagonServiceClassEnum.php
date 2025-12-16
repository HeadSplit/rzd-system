<?php

namespace App\Enums;

Enum WagonServiceClassEnum: string
{
    case basic = "default";
    case normal = "normal";
    case business = "business";
    case firstClass = "firstClass";
    case suite = "suite";
    case premium = "premium";
    case meetingRoom = "meetingRoom";
    case invalid = "invalid";

    public function getBasePriceRange(): array
    {
        return match($this) {
            self::basic => [4000, 8000],
            self::normal => [6000, 12000],
            self::business => [10000, 20000],
            self::firstClass => [15000, 30000],
            self::suite => [25000, 50000],
            self::premium => [40000, 80000],
            self::meetingRoom => [50000, 100000],
            self::invalid => [3000, 6000],
        };
    }
}
