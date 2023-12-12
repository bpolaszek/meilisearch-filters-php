<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function sprintf;

final class NotExpression extends Expression
{
    public function __construct(
        public readonly Expression $expression,
    ) {
    }

    public function and(Expression $expression, Expression ...$expressions): Expression
    {
        return $this->group()->and($expression, ...$expressions);
    }

    public function or(Expression $expression, Expression ...$expressions): Expression
    {
        return $this->group()->or($expression, ...$expressions);
    }

    public function negate(): Expression
    {
        return $this->expression;
    }

    public function __toString(): string
    {
        return sprintf('NOT %s', $this->expression);
    }
}
