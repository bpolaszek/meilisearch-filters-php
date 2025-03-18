<?php

declare(strict_types=1);

namespace Bentools\MeilisearchFilters;

/**
 * @internal
 */
final readonly class Field
{
    public function __construct(public string $field)
    {
    }

    public function equals(mixed $value): Expression
    {
        return null === $value ? new IsNullExpression($this->field) : new ComparisonExpression($this->field, $value);
    }

    public function notEquals(mixed $value): Expression
    {
        return $this->equals($value)->negate();
    }

    public function isGreaterThan(mixed $value, bool $includeValue = false): Expression
    {
        return new ComparisonExpression(
            $this->field,
            $value,
            $includeValue ? ComparisonOperator::GREATER_THAN_OR_EQUALS : ComparisonOperator::GREATER_THAN,
        );
    }

    public function isNotGreaterThan(mixed $value, bool $includeValue = false): Expression
    {
        return $this->isGreaterThan($value, $includeValue)->negate();
    }

    public function isLowerThan(mixed $value, bool $includeValue = false): Expression
    {
        return new ComparisonExpression(
            $this->field,
            $value,
            $includeValue ? ComparisonOperator::LOWER_THAN_OR_EQUALS : ComparisonOperator::LOWER_THAN,
        );
    }

    public function isNotLowerThan(mixed $value, bool $includeValue = false): Expression
    {
        return $this->isLowerThan($value, $includeValue)->negate();
    }

    public function isBetween(mixed $left, mixed $right, bool $includeBoundaries = true): Expression
    {
        return $includeBoundaries
            ? new BetweenExpression($this->field, $left, $right)
            : $this->isGreaterThan($left)->and($this->isLowerThan($right));
    }

    public function isNotBetween(mixed $left, mixed $right, bool $includeBoundaries = true): Expression
    {
        return $this->isBetween($left, $right, $includeBoundaries)->negate();
    }

    public function exists(): Expression
    {
        return new ExistsExpression($this->field);
    }

    public function doesNotExist(): Expression
    {
        return $this->exists()->negate();
    }

    public function isNull(): Expression
    {
        return new IsNullExpression($this->field);
    }

    public function isNotNull(): Expression
    {
        return $this->isNull()->negate();
    }

    public function isEmpty(): Expression
    {
        return new IsEmptyExpression($this->field);
    }

    public function isNotEmpty(): Expression
    {
        return $this->isEmpty()->negate();
    }

    /**
     * @param list<mixed> $values
     */
    public function isIn(array $values): Expression
    {
        return new InExpression($this->field, $values);
    }

    /**
     * @param list<mixed> $values
     */
    public function isNotIn(array $values): Expression
    {
        return $this->isIn($values)->negate();
    }

    /**
     * @param list<mixed> $values
     */
    public function hasAll(array $values): Expression
    {
        return new HasAllExpression($this->field, $values);
    }

    /**
     * @param list<mixed> $values
     */
    public function hasNone(array $values): Expression
    {
        return $this->hasAll($values)->negate();
    }

    public function contains(mixed $value): Expression
    {
        return new ContainsExpression($this->field, $value);
    }

    public function doesNotContain(mixed $value): Expression
    {
        return $this->contains($value)->negate();
    }

    public function startsWith(mixed $value): Expression
    {
        return new StartsWithExpression($this->field, $value);
    }

    public function doesNotStartWith(mixed $value): Expression
    {
        return $this->startsWith($value)->negate();
    }
}
