<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function sprintf;

class ExistsExpression extends Expression
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
        return $this->negated ? sprintf('%s NOT EXISTS', $this->field) : sprintf('%s EXISTS', $this->field);
    }
}