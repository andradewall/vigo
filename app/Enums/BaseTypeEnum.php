<?php

namespace App\Enums;

enum BaseTypeEnum: int
{
    case COUNTABLE  = 1;
    case MEASURABLE = 2;

    public function baseName(): string
    {
        return match ($this) {
            self::COUNTABLE  => 'unidade',
            self::MEASURABLE => 'metro',
        };
    }

    public function componentName(): string
    {
        return match ($this) {
            self::COUNTABLE  => 'quantity',
            self::MEASURABLE => 'meter',
        };
    }

    public function isMeasurable(): bool
    {
        return $this->value === self::MEASURABLE->value;
    }
}
