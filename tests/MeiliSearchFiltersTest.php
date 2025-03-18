<?php

namespace Bentools\MeilisearchFilters\Tests;

use function Bentools\MeilisearchFilters\field;
use function Bentools\MeilisearchFilters\notWithinGeoBoundingBox;
use function Bentools\MeilisearchFilters\notWithinGeoRadius;
use function Bentools\MeilisearchFilters\withinGeoBoundingBox;
use function Bentools\MeilisearchFilters\withinGeoRadius;
use function describe;
use function expect;

describe('EQUALS filter', function () {
    it('stringifies the filter', function () {
        $expression = field('cat')->equals('Berlioz');
        expect((string) $expression)->toEqual("cat = 'Berlioz'")
            ->and($expression)->toHaveCount(1);
    });

    it('stringifies the negated filter', function () {
        $expression = field('cat')->notEquals('Berlioz');
        expect((string) $expression)->toEqual("cat != 'Berlioz'")
            ->and($expression)->toHaveCount(1);
    });
});

describe('GreaterThan filter', function () {
    it('stringifies the filter', function () {
        $expression = field('age')->isGreaterThan(5);
        expect((string) $expression)->toEqual("age > '5'")
            ->and($expression)->toHaveCount(1);
    });

    it('stringifies the negated filter', function () {
        $expression = field('age')->isNotGreaterThan(5);
        expect((string) $expression)->toEqual("age <= '5'")
            ->and($expression)->toHaveCount(1);
    });
});

describe('GreaterThanOrEquals filter', function () {
    it('stringifies the filter', function () {
        $expression = field('age')->isGreaterThan(5, true);
        expect((string) $expression)->toEqual("age >= '5'")
            ->and($expression)->toHaveCount(1);
    });

    it('stringifies the negated filter', function () {
        $expression = field('age')->isNotGreaterThan(5, true);
        expect((string) $expression)->toEqual("age < '5'")
            ->and($expression)->toHaveCount(1);
    });
});

describe('LowerThan filter', function () {
    it('stringifies the filter', function () {
        $expression = field('age')->isLowerThan(5);
        expect((string) $expression)->toEqual("age < '5'")
            ->and($expression)->toHaveCount(1);
    });

    it('stringifies the negated filter', function () {
        $expression = field('age')->isNotLowerThan(5);
        expect((string) $expression)->toEqual("age >= '5'")
            ->and($expression)->toHaveCount(1);
    });
});

describe('LowerThanOrEquals filter', function () {
    it('stringifies the filter', function () {
        $expression = field('age')->isLowerThan(5, true);
        expect((string) $expression)->toEqual("age <= '5'")
            ->and($expression)->toHaveCount(1);
    });

    it('stringifies the negated filter', function () {
        $expression = field('age')->isNotLowerThan(5, true);
        expect((string) $expression)->toEqual("age > '5'")
            ->and($expression)->toHaveCount(1);
    });
});

describe('BETWEEN filter, boundaries included', function () {
    it('stringifies the filter', function () {
        $expression = field('age')->isBetween(5, 10);
        expect((string) $expression)->toEqual("age '5' TO '10'")
            ->and($expression)->toHaveCount(1);
    });

    it('stringifies the negated filter', function () {
        $expression = field('age')->isNotBetween(5, 10);
        expect((string) $expression)->toEqual("NOT age '5' TO '10'")
            ->and($expression)->toHaveCount(1);
    });
});

describe('BETWEEN filter, boundaries excluded', function () {
    it('stringifies the filter', function () {
        $expression = field('age')->isBetween(5, 10, false);
        expect((string) $expression)->toEqual("age > '5' AND age < '10'")
            ->and($expression)->toHaveCount(2);
    });

    it('stringifies the negated filter', function () {
        $expression = field('age')->isNotBetween(5, 10, false);
        expect((string) $expression)->toEqual("NOT (age > '5' AND age < '10')")
            ->and($expression)->toHaveCount(2);
    });
});

describe('EXISTS filter', function () {
    it('stringifies the filter', function () {
        $expression = field('god')->exists();
        expect((string) $expression)->toEqual('god EXISTS')
            ->and($expression)->toHaveCount(1);
    });

    it('stringifies the negated filter', function () {
        $expression = field('god')->doesNotExist();
        expect((string) $expression)->toEqual('god NOT EXISTS')
            ->and($expression)->toHaveCount(1);
    });
});

describe('EMPTY filter', function () {
    it('stringifies the filter', function () {
        $expression = field('glass')->isEmpty();
        expect((string) $expression)->toEqual('glass IS EMPTY')
            ->and($expression)->toHaveCount(1);
    });

    it('stringifies the negated filter', function () {
        $expression = field('glass')->isNotEmpty();
        expect((string) $expression)->toEqual('glass IS NOT EMPTY')
            ->and($expression)->toHaveCount(1);
    });
});

describe('NULL filter', function () {
    it('stringifies the filter', function () {
        $expression = field('nullish')->isNull();
        expect((string) $expression)->toEqual('nullish IS NULL')
            ->and($expression)->toHaveCount(1);
    });

    it('stringifies the negated filter', function () {
        $expression = field('nullish')->isNotNull();
        expect((string) $expression)->toEqual('nullish IS NOT NULL')
            ->and($expression)->toHaveCount(1);
    });
});

describe('IN filter', function () {
    $cat = field('cat');

    it('stringifies the filter', function () use ($cat) {
        $expression = $cat->isIn(['Berlioz', "O'Malley"]);
        expect((string) $expression)->toEqual("cat IN ['Berlioz', 'O\\'Malley']")
            ->and($expression)->toHaveCount(1);
    });

    it('stringifies the negated filter', function () use ($cat) {
        $expression = $cat->isNotIn(['Berlioz', "O'Malley"]);
        expect((string) $expression)->toEqual("cat NOT IN ['Berlioz', 'O\\'Malley']")
            ->and($expression)->toHaveCount(1);
    });
});

describe('hasAll / hasNone filter', function () {
    $color = field('color');

    it('stringifies the filter', function () use ($color) {
        $expression = $color->hasAll(['blue', 'green']);
        expect((string) $expression)->toEqual("color = 'blue' AND color = 'green'")
            ->and($expression)->toHaveCount(2);
    });

    it('stringifies the negated filter', function () use ($color) {
        $expression = $color->hasNone(['blue', 'green']);
        expect((string) $expression)->toEqual("NOT (color = 'blue' AND color = 'green')")
            ->and($expression)->toHaveCount(2);
    });
});

describe('CONTAINS filter', function () {
    it('stringifies the filter', function () {
        $expression = field('cat')->contains('Berlioz');
        expect((string) $expression)->toEqual("cat CONTAINS 'Berlioz'")
            ->and($expression)->toHaveCount(1);
    });

    it('stringifies the negated filter', function () {
        $expression = field('cat')->doesNotContain('Berlioz');
        expect((string) $expression)->toEqual("cat NOT CONTAINS 'Berlioz'")
            ->and($expression)->toHaveCount(1);
    });
});

describe('STARTS WITH filter', function () {
    it('stringifies the filter', function () {
        $expression = field('cat')->startsWith('Ber');
        expect((string) $expression)->toEqual("cat STARTS WITH 'Ber'")
            ->and($expression)->toHaveCount(1);
    });

    it('stringifies the negated filter', function () {
        $expression = field('cat')->doesNotStartWith('Ber');
        expect((string) $expression)->toEqual("cat NOT STARTS WITH 'Ber'")
            ->and($expression)->toHaveCount(1);
    });
});

describe('OR filter', function () {
    $cat = field('cat');
    $expression = $cat->equals('Berlioz')->or($cat->equals("O'Malley"));

    it('stringifies the filter', function () use ($expression) {
        expect((string) $expression)->toEqual("cat = 'Berlioz' OR cat = 'O\\'Malley'")
            ->and($expression)->toHaveCount(2);
    });

    it('stringifies the negated filter', function () use ($expression) {
        expect((string) $expression->negate())->toEqual("NOT (cat = 'Berlioz' OR cat = 'O\\'Malley')")
            ->and($expression)->toHaveCount(2);
    });
});

describe('AND filter', function () {
    $cat = field('cat');
    $expression = $cat->equals('Berlioz')->and($cat->equals("O'Malley"));

    it('stringifies the filter', function () use ($expression) {
        expect((string) $expression)->toEqual("cat = 'Berlioz' AND cat = 'O\\'Malley'")
            ->and($expression)->toHaveCount(2);
    });

    it('stringifies the negated filter', function () use ($expression) {
        expect((string) $expression->negate())->toEqual("NOT (cat = 'Berlioz' AND cat = 'O\\'Malley')")
            ->and($expression)->toHaveCount(2);
    });
});

describe('GeoRadius filter', function () {
    it('stringifies the filter', function () {
        $expression = withinGeoRadius(50.35, 3.51, 3000);
        expect((string) $expression)->toEqual('_geoRadius(50.35, 3.51, 3000)')
            ->and($expression)->toHaveCount(1);
    });

    it('stringifies the negated filter', function () {
        $expression = notWithinGeoRadius(50.35, 3.51, 3000);
        expect((string) $expression)->toEqual('NOT _geoRadius(50.35, 3.51, 3000)')
            ->and($expression)->toHaveCount(1);
    });
});

describe('GeoBoundingBox filter', function () {
    it('stringifies the filter', function () {
        $expression = withinGeoBoundingBox([50.55, 3], [50.52, 3.08]);
        expect((string) $expression)->toEqual('_geoBoundingBox([50.55, 3], [50.52, 3.08])')
            ->and($expression)->toHaveCount(1);
    });

    it('stringifies the negated filter', function () {
        $expression = notWithinGeoBoundingBox([50.55, 3], [50.52, 3.08]);
        expect((string) $expression)->toEqual('NOT _geoBoundingBox([50.55, 3], [50.52, 3.08])')
            ->and($expression)->toHaveCount(1);
    });
});
