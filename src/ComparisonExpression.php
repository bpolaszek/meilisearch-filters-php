<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function sprintf;

final class ComparisonExpression extends Expression
{
    public function __construct(
        public readonly string $field,
        public readonly mixed $value,
        public readonly ComparisonOperator $operator = ComparisonOperator::EQUALS,
    ) {
    }

    public function negate(): Expression
    {
        return new self($this->field, $this->value, $this->operator->negate());
    }

    public function __toString(): string
    {
        return sprintf('%s %s %s', $this->field, $this->operator->value, escape($this->value));
    }
}
