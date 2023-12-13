<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function array_reduce;
use function count;

abstract class CompositeExpression extends Expression
{
    public function __construct(
        public readonly Expressions $expressions,
    ) {
    }

    public function negate(): Expression
    {
        return $this->group()->negate();
    }

    public function count(): int
    {
        return array_reduce([...$this->expressions], fn ($i, Expression $expression) => $i += count($expression), 0);
    }
}
