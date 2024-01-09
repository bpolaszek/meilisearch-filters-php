<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use Countable;
use Stringable;

abstract class Expression implements Countable, Stringable
{
    public function and(Expression $expression, Expression ...$expressions): Expression
    {
        return new AndExpression(new Expressions($this, $expression, ...$expressions));
    }

    public function or(Expression $expression, Expression ...$expressions): Expression
    {
        return new OrExpression(new Expressions($this, $expression, ...$expressions));
    }

    public function negate(): Expression
    {
        return new NotExpression($this);
    }

    public function group(): Expression
    {
        return new GroupExpression($this);
    }
}
