<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

final class AndExpression extends CompositeExpression
{
    public function __toString(): string
    {
        return $this->expressions->join(' AND ');
    }
}
