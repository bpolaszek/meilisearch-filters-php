<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function sprintf;

class IsEmptyExpression extends Expression
{
    public function __construct(
        public readonly string $field,
        public readonly bool $negated = false,
    ) {
    }

    public function negate(): Expression
    {
        return new self($this->field, !$this->negated);
    }

    public function __toString(): string
    {
        return $this->negated ? sprintf('%s IS NOT EMPTY', $this->field) : sprintf('%s IS EMPTY', $this->field);
    }
}
