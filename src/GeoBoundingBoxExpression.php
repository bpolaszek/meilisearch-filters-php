<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function sprintf;

final class GeoBoundingBoxExpression extends Expression
{
    public function __construct(
        public readonly BoundingBox $boundingBox,
    ) {
    }

    public function __toString(): string
    {
        return sprintf('_geoBoundingBox(%s)', $this->boundingBox);
    }
}
