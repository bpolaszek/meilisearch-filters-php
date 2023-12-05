<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function implode;
use function sprintf;

class InExpression extends Expression
{
    /**
     * @param array<mixed> $values
     */
    public function __construct(
        public readonly string $field,
        public readonly array $values,
        public readonly bool $negated = false,
    ) {
    }

    public function negate(): self
    {
        return new self($this->field, $this->values, !$this->negated);
    }

    public function __toString(): string
    {
        return $this->negated
            ? sprintf('%s NOT IN [%s]', $this->field, implode(', ', escape($this->values)))
            : sprintf('%s IN [%s]', $this->field, implode(', ', escape($this->values)));
    }
}
