<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use function sprintf;

final class GeoRadiusExpression extends Expression
{
    public readonly Coordinates $coordinates;

    /**
     * @param Coordinates|array{string|float, string|float} $coordinates
     */
    public function __construct(
        Coordinates|array $coordinates,
        public readonly int $distanceInmeters,
    ) {
        $this->coordinates = Coordinates::from($coordinates);
    }

    public function __toString(): string
    {
        return sprintf('_geoRadius(%s, %s)', $this->coordinates, $this->distanceInmeters);
    }
}
