<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function sprintf;

final class GroupExpression extends Expression
{
    public function __construct(
        public readonly Expression $expression,
    ) {
    }

    public function __toString(): string
    {
        if ($this->expression instanceof self) {
            return (string) $this->expression;
        }

        return sprintf('(%s)', $this->expression);
    }

    public function count(): int
    {
        return $this->expression->count();
    }
}
