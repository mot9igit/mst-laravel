<?php

namespace App\Enums;

enum StoreIntegrationType: int
{
    case MODULE = 1;
    case YML = 2;
    case XLS = 3;

    public function label(): string
    {
        return match($this) {
            self::MODULE => 'Модуль 1С',
            self::YML => 'YML файл',
            self::XLS => 'Excel файл'
        };
    }
}
