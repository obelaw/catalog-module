<?php

namespace Obelaw\Catalog\Enums;

use Exception;
use Filament\Support\Contracts\HasLabel;

enum ProductType: int implements HasLabel
{
    case SIMPLE = 1;
    case CONFIGURABLE = 2;

    public static function __callStatic($name, $args)
    {
        $name = strtoupper($name);

        if ($case = array_filter(static::cases(), fn($case) => $case->name == $name))
            return current($case)->value;

        throw new Exception('This case does not exists');
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SIMPLE => 'Simple',
            self::CONFIGURABLE => 'Configurable',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SIMPLE => 'success',
            self::CONFIGURABLE => 'warning',
        };
    }
}
