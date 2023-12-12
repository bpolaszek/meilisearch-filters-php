<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function sprintf;

final class ComparisonExpression extends FieldExpression
{
    public function __construct(
        string $field,
        public readonly mixed $value,
        public readonly ComparisonOperator $operator = ComparisonOperator::EQUALS,
    ) {
        parent::__construct($field);
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
