<?php

namespace Obelaw\Catalog\Enums;

use Exception;
use Filament\Support\Contracts\HasLabel;

enum OptionsPriceType: string implements HasLabel
{
    case FORCE = 'force';
    case APPEND = 'append';

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
            self::FORCE => 'Force',
            self::APPEND => 'Append',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::FORCE => 'success',
            self::APPEND => 'warning',
        };
    }
}
