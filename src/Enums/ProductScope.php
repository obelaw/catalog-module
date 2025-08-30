<?php

namespace Obelaw\Catalog\Enums;

use Exception;
use Filament\Support\Contracts\HasLabel;

enum ProductScope: int implements HasLabel
{
    case RAW_MATERIAL = 1;
    case SEMI_FINISHED = 2;
    case FINISHED = 3;

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
            self::RAW_MATERIAL => 'Raw Material',
            self::SEMI_FINISHED => 'Semi Finished',
            self::FINISHED => 'Finished',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::RAW_MATERIAL => 'success',
            self::SEMI_FINISHED => 'warning',
            self::FINISHED => 'gray',
        };
    }
}
