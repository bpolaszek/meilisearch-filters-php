<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function implode;
use function sprintf;

final class InExpression extends FieldExpression
{
    /**
     * @param array<mixed> $values
     */
    public function __construct(
        string $field,
        public readonly array $values,
        public readonly bool $negated = false,
    ) {
        parent::__construct($field);
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
