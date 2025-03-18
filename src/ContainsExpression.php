<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function sprintf;

final class ContainsExpression extends FieldExpression
{
    private bool $negated = false;

    public function __construct(
        string $field,
        public readonly mixed $value,
    ) {
        parent::__construct($field);
    }

    public function negate(): Expression
    {
        $expression = new self($this->field, $this->value);
        $expression->negated = !$this->negated;

        return $expression;
    }

    public function __toString(): string
    {
        return $this->negated
            ? sprintf('%s NOT CONTAINS %s', $this->field, escape($this->value))
            : sprintf('%s CONTAINS %s', $this->field, escape($this->value));
    }
}
