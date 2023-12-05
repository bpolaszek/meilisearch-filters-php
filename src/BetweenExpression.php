<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function sprintf;

class BetweenExpression extends Expression
{
    public function __construct(
        public readonly string $field,
        public readonly mixed $left,
        public readonly mixed $right,
    ) {
    }

    public function __toString(): string
    {
        return sprintf('%s %s TO %s', $this->field, escape($this->left), escape($this->right));
    }
}
