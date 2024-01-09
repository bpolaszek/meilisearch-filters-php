<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function array_map;
use function count;

final class HasAllExpression extends FieldExpression
{
    private Expression $innerExpression;

    /**
     * @param array<mixed> $values
     */
    public function __construct(
        string $field,
        public readonly array $values,
        public readonly bool $negated = false,
    ) {
        parent::__construct($field);
        $innerExpression = new AndExpression(
            new Expressions(...array_map(fn (mixed $value) => field($this->field)->equals($value), $values)),
        );
        if ($negated) {
            $innerExpression = $innerExpression->negate();
        }

        $this->innerExpression = $innerExpression;
    }

    public function negate(): self
    {
        return new self($this->field, $this->values, !$this->negated);
    }

    public function __toString(): string
    {
        return (string) $this->innerExpression;
    }

    public function count(): int
    {
        return count($this->values);
    }
}
