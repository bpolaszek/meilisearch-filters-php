<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use Stringable;

abstract class Expression implements Stringable
{
    public function and(Expression $expression): AndExpression
    {
        if ($expression instanceof CompositeExpression) {
            $expression = $expression->group();
        }

        return new AndExpression(new Expressions($this, $expression));
    }

    public function or(Expression $expression): OrExpression
    {
        if ($expression instanceof CompositeExpression) {
            $expression = $expression->group();
        }

        return new OrExpression(new Expressions($this, $expression));
    }

    public function negate(): Expression
    {
        return new NotExpression($this);
    }

    public function group(): GroupExpression
    {
        return new GroupExpression($this);
    }
}
