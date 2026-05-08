<?php

namespace App\Enums;

enum StoreDocRemainType: int
{
    case SALE = 1;
    case REFUND = 2;

    public function label(): string
    {
        return match($this) {
            self::SALE => 'Продажа',
            self::REFUND => 'Возврат',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::SALE => '000000',
            self::REFUND => 'C0C0C0',
        };
    }
}
