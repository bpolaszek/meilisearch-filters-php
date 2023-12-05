<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use Stringable;

use function sprintf;

final readonly class Coordinates implements Stringable
{
    public function __construct(
        public string|float $latitude,
        public string|float $longitude,
    ) {
    }

    public function __toString(): string
    {
        return sprintf('%s, %s', $this->latitude, $this->longitude);
    }

    /**
     * @param Coordinates|array{string|float, string|float} $coordinates
     */
    public static function from(self|array $coordinates): self
    {
        if ($coordinates instanceof self) {
            return $coordinates;
        }

        [$latitude, $longitude] = $coordinates;

        return new self($latitude, $longitude);
    }
}
