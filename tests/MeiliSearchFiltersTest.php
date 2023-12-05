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
        expect((string) $expression)->toEqual("cat = 'Berlioz'");
    });

    it('stringifies the negated filter', function () {
        $expression = field('cat')->notEquals('Berlioz');
        expect((string) $expression)->toEqual("cat != 'Berlioz'");
    });
});

describe('GreaterThan filter', function () {
    it('stringifies the filter', function () {
        $expression = field('age')->isGreaterThan(5);
        expect((string) $expression)->toEqual("age > '5'");
    });

    it('stringifies the negated filter', function () {
        $expression = field('age')->isNotGreaterThan(5);
        expect((string) $expression)->toEqual("age <= '5'");
    });
});

describe('GreaterThanOrEquals filter', function () {
    it('stringifies the filter', function () {
        $expression = field('age')->isGreaterThan(5, true);
        expect((string) $expression)->toEqual("age >= '5'");
    });

    it('stringifies the negated filter', function () {
        $expression = field('age')->isNotGreaterThan(5, true);
        expect((string) $expression)->toEqual("age < '5'");
    });
});

describe('LowerThan filter', function () {
    it('stringifies the filter', function () {
        $expression = field('age')->isLowerThan(5);
        expect((string) $expression)->toEqual("age < '5'");
    });

    it('stringifies the negated filter', function () {
        $expression = field('age')->isNotLowerThan(5);
        expect((string) $expression)->toEqual("age >= '5'");
    });
});

describe('LowerThanOrEquals filter', function () {
    it('stringifies the filter', function () {
        $expression = field('age')->isLowerThan(5, true);
        expect((string) $expression)->toEqual("age <= '5'");
    });

    it('stringifies the negated filter', function () {
        $expression = field('age')->isNotLowerThan(5, true);
        expect((string) $expression)->toEqual("age > '5'");
    });
});

describe('BETWEEN filter, boundaries included', function () {
    it('stringifies the filter', function () {
        $expression = field('age')->isBetween(5, 10);
        expect((string) $expression)->toEqual("age '5' TO '10'");
    });

    it('stringifies the negated filter', function () {
        $expression = field('age')->isNotBetween(5, 10);
        expect((string) $expression)->toEqual("NOT age '5' TO '10'");
    });
});

describe('BETWEEN filter, boundaries excluded', function () {
    it('stringifies the filter', function () {
        $expression = field('age')->isBetween(5, 10, false);
        expect((string) $expression)->toEqual("age > '5' AND age < '10'");
    });

    it('stringifies the negated filter', function () {
        $expression = field('age')->isNotBetween(5, 10, false);
        expect((string) $expression)->toEqual("NOT (age > '5' AND age < '10')");
    });
});

describe('EXISTS filter', function () {
    it('stringifies the filter', function () {
        $expression = field('god')->exists();
        expect((string) $expression)->toEqual('god EXISTS');
    });

    it('stringifies the negated filter', function () {
        $expression = field('god')->doesNotExist();
        expect((string) $expression)->toEqual('god NOT EXISTS');
    });
});

describe('EMPTY filter', function () {
    it('stringifies the filter', function () {
        $expression = field('glass')->isEmpty();
        expect((string) $expression)->toEqual('glass IS EMPTY');
    });

    it('stringifies the negated filter', function () {
        $expression = field('glass')->isNotEmpty();
        expect((string) $expression)->toEqual('glass IS NOT EMPTY');
    });
});

describe('NULL filter', function () {
    it('stringifies the filter', function () {
        $expression = field('nullish')->isNull();
        expect((string) $expression)->toEqual('nullish IS NULL');
    });

    it('stringifies the negated filter', function () {
        $expression = field('nullish')->isNotNull();
        expect((string) $expression)->toEqual('nullish IS NOT NULL');
    });
});

describe('IN filter', function () {
    $cat = field('cat');

    it('stringifies the filter', function () use ($cat) {
        $expression = $cat->isIn(['Berlioz', "O'Malley"]);
        expect((string) $expression)->toEqual("cat IN ['Berlioz', 'O\\'Malley']");
    });

    it('stringifies the negated filter', function () use ($cat) {
        $expression = $cat->isNotIn(['Berlioz', "O'Malley"]);
        expect((string) $expression)->toEqual("cat NOT IN ['Berlioz', 'O\\'Malley']");
    });
});

describe('OR filter', function () {
    $cat = field('cat');
    $expression = $cat->equals('Berlioz')->or($cat->equals("O'Malley"));

    it('stringifies the filter', function () use ($expression) {
        expect((string) $expression)->toEqual("cat = 'Berlioz' OR cat = 'O\\'Malley'");
    });

    it('stringifies the negated filter', function () use ($expression) {
        expect((string) $expression->negate())->toEqual("NOT (cat = 'Berlioz' OR cat = 'O\\'Malley')");
    });
});

describe('AND filter', function () {
    $cat = field('cat');
    $expression = $cat->equals('Berlioz')->and($cat->equals("O'Malley"));

    it('stringifies the filter', function () use ($expression) {
        expect((string) $expression)->toEqual("cat = 'Berlioz' AND cat = 'O\\'Malley'");
    });

    it('stringifies the negated filter', function () use ($expression) {
        expect((string) $expression->negate())->toEqual("NOT (cat = 'Berlioz' AND cat = 'O\\'Malley')");
    });
});

describe('GeoRadius filter', function () {
    it('stringifies the filter', function () {
        $expression = withinGeoRadius(50.35, 3.51, 3000);
        expect((string) $expression)->toEqual('_geoRadius(50.35, 3.51, 3000)');
    });

    it('stringifies the negated filter', function () {
        $expression = notWithinGeoRadius(50.35, 3.51, 3000);
        expect((string) $expression)->toEqual('NOT _geoRadius(50.35, 3.51, 3000)');
    });
});

describe('GeoBoundingBox filter', function () {
    it('stringifies the filter', function () {
        $expression = withinGeoBoundingBox([50.55, 3], [50.52, 3.08]);
        expect((string) $expression)->toEqual('_geoBoundingBox([50.55, 3], [50.52, 3.08])');
    });

    it('stringifies the negated filter', function () {
        $expression = notWithinGeoBoundingBox([50.55, 3], [50.52, 3.08]);
        expect((string) $expression)->toEqual('NOT _geoBoundingBox([50.55, 3], [50.52, 3.08])');
    });
});
