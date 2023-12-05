<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use Stringable;

use function addslashes;
use function array_map;
use function func_get_args;
use function is_array;
use function is_bool;
use function sprintf;

/**
 * @param string|float|int|bool|Stringable|list<string|float|int|bool|Stringable> $value
 *
 * @return string|list<string>
 */
function escape(string|float|int|bool|Stringable|array $value): string|array
{
    if (is_array($value)) {
        return array_map(__FUNCTION__, $value);
    }

    if (is_bool($value)) {
        $value = $value ? 'true' : 'false';
    }

    return sprintf('\'%s\'', addslashes((string) $value));
}

function field(string $field): Field
{
    return new Field($field);
}

function not(Expression $expression): NotExpression
{
    return new NotExpression($expression);
}

function group(Expression $expression): GroupExpression
{
    return new GroupExpression($expression);
}

function withinGeoRadius(string|float $latitude, string|float $longitude, string|float|int $distanceInMeters): Expression
{
    return new GeoRadiusExpression(new Coordinates($latitude, $longitude), (int) $distanceInMeters);
}

function notWithinGeoRadius(string|float $latitude, string|float $longitude, string|float|int $distanceInMeters): Expression
{
    return withinGeoRadius(...func_get_args())->negate();
}

/**
 * @param Coordinates|array{string|float, string|float} $topLeftCorner
 * @param Coordinates|array{string|float, string|float} $bottomRightCorner
 */
function withinGeoBoundingBox(Coordinates|array $topLeftCorner, Coordinates|array $bottomRightCorner): Expression
{
    return new GeoBoundingBoxExpression(new BoundingBox($topLeftCorner, $bottomRightCorner));
}

/**
 * @param Coordinates|array{string|float, string|float} $topLeftCorner
 * @param Coordinates|array{string|float, string|float} $bottomRightCorner
 */
function notWithinGeoBoundingBox(Coordinates|array $topLeftCorner, Coordinates|array $bottomRightCorner): Expression
{
    return withinGeoBoundingBox(...func_get_args())->negate();
}
