<?php

namespace Obelaw\Catalog\Enums;

use Filament\Support\Contracts\HasLabel;

enum StockType: int implements HasLabel
{
    case CONSUMABLE = 1;
    case SERVICE = 2;
    case STORABLE = 3;

    public static function __callStatic($name, $args)
    {
        $name = strtoupper($name);

        if ($case = array_filter(static::cases(), fn($case) => $case->name == $name))
            return current($case)->value;

        throw new \Exception('This case does not exists');
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CONSUMABLE => 'Consumable',
            self::SERVICE => 'Service',
            self::STORABLE => 'Storable',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::CONSUMABLE => 'success',
            self::SERVICE => 'warning',
            self::STORABLE => 'warning',
        };
    }
}
