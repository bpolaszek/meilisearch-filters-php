<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

final class OrExpression extends CompositeExpression
{
    public function __toString(): string
    {
        return $this->expressions->join(' OR ');
    }
}
