<?php

namespace Bentools\MeilisearchFilters;

enum ComparisonOperator: string
{
    case EQUALS = '=';
    case NOT_EQUALS = '!=';
    case GREATER_THAN = '>';
    case GREATER_THAN_OR_EQUALS = '>=';
    case LOWER_THAN = '<';
    case LOWER_THAN_OR_EQUALS = '<=';

    public function negate(): self
    {
        return match ($this) {
            self::EQUALS => self::NOT_EQUALS,
            self::NOT_EQUALS => self::EQUALS,
            self::GREATER_THAN => self::LOWER_THAN_OR_EQUALS,
            self::GREATER_THAN_OR_EQUALS => self::LOWER_THAN,
            self::LOWER_THAN => self::GREATER_THAN_OR_EQUALS,
            self::LOWER_THAN_OR_EQUALS => self::GREATER_THAN,
        };
    }
}
