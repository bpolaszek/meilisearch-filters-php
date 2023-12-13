<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

use IteratorAggregate;
use Traversable;

use function array_filter;
use function array_map;
use function array_values;
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

    public function __construct(Expression ...$expressions)
    {
        $expressions = array_values(
            array_filter($expressions, fn (Expression $expression) => !$expression instanceof EmptyExpression)
        );
        $this->expressions = array_map($this->groupIfNecessary(...), $expressions);
    }

    public function join(string $delimiter): string
    {
        return implode($delimiter, $this->expressions);
    }

    public function getIterator(): Traversable
    {
        yield from $this->expressions;
    }

    private function groupIfNecessary(Expression $expression): Expression
    {
        return $expression instanceof CompositeExpression ? $expression->group() : $expression;
    }
}
