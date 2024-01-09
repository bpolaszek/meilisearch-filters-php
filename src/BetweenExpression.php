<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function sprintf;

final class BetweenExpression extends FieldExpression
{
    public function __construct(
        string $field,
        public readonly mixed $left,
        public readonly mixed $right,
    ) {
        parent::__construct($field);
    }

    public function __toString(): string
    {
        return sprintf('%s %s TO %s', $this->field, escape($this->left), escape($this->right));
    }
}
