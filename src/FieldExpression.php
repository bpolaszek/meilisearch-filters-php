<?php

namespace Bentools\MeilisearchFilters;

abstract class FieldExpression extends Expression
{
    public function __construct(
        public readonly string $field,
    ) {
    }
}
