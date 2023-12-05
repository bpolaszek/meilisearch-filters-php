<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use Stringable;

use function sprintf;

final readonly class BoundingBox implements Stringable
{
    public Coordinates $topLeftCorner;
    public Coordinates $bottomRightCorner;

    /**
     * @param Coordinates|array{string|float, string|float} $topLeftCorner
     * @param Coordinates|array{string|float, string|float} $bottomRightCorner
     */
    public function __construct(
        Coordinates|array $topLeftCorner,
        Coordinates|array $bottomRightCorner,
    ) {
        $this->topLeftCorner = Coordinates::from($topLeftCorner);
        $this->bottomRightCorner = Coordinates::from($bottomRightCorner);
    }

    public function __toString(): string
    {
        return sprintf('[%s], [%s]', $this->topLeftCorner, $this->bottomRightCorner);
    }
}
