<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use IteratorAggregate;
use Traversable;

use function implode;

/**
 * @internal
 *
 * @implements IteratorAggregate<Expression>
 */
final readonly class Expressions implements IteratorAggregate
{
    /**
     * @var Expression[]
     */
    private array $expressions;

    public function __construct(
        Expression ...$expressions
    ) {
        $this->expressions = $expressions;
    }

    public function join(string $delimiter): string
    {
        return implode($delimiter, $this->expressions);
    }

    public function getIterator(): Traversable
    {
        yield from $this->expressions;
    }
}
