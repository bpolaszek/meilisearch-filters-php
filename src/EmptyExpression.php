<?php

namespace Bentools\MeilisearchFilters;

final class EmptyExpression extends Expression
{
    public function __toString(): string
    {
        return '';
    }

    public function and(Expression $expression, Expression ...$expressions): Expression
    {
        return [] === $expressions ? $expression : new AndExpression(new Expressions($expression, ...$expressions));
    }

    public function or(Expression $expression, Expression ...$expressions): Expression
    {
        return [] === $expressions ? $expression : new OrExpression(new Expressions($expression, ...$expressions));
    }

    public function negate(): Expression
    {
        return $this;
    }

    public function group(): Expression
    {
        return $this;
    }

    public function count(): int
    {
        return 0;
    }
}
