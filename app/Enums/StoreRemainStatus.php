<?php

namespace App\Enums;

enum StoreRemainStatus: int
{
    case NO_BRAND = 1;
    case NO_ARTICLE = 2;
    case CHECKED = 3;
    case NO_CARD = 4;
    case NO_PRICE = 5;
    case CHECK_PRICE = 6;

    public function label(): string
    {
        return match($this) {
            self::NO_BRAND => 'Укажите бренд',
            self::NO_ARTICLE => 'Укажите артикул',
            self::CHECKED => 'Сопоставлен',
            self::NO_CARD => 'Нет карточки товара',
            self::NO_PRICE => 'Укажите цену',
            self::CHECK_PRICE => 'Проверьте цену'
        };
    }

    public function color(): string
    {
        return match($this) {
            self::NO_BRAND => '000000',
            self::NO_ARTICLE => 'C0C0C0',
            self::CHECKED => '00FF00',
            self::NO_CARD => 'FF0000',
            self::NO_PRICE => '969696',
            self::CHECK_PRICE => '464646'
        };
    }
}
