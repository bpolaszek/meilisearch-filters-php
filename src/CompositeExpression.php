<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

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
}
