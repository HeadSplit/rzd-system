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
}
