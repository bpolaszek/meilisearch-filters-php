[![Latest Stable Version](https://poser.pugx.org/bentools/meilisearch-filters/v/stable)](https://packagist.org/packages/bentools/meilisearch-filters)
[![License](https://poser.pugx.org/bentools/meilisearch-filters/license)](https://packagist.org/packages/bentools/meilisearch-filters)
[![CI Workflow](https://github.com/bpolaszek/meilisearch-filters-php/actions/workflows/ci.yml/badge.svg)](https://github.com/bpolaszek/meilisearch-filters-php/actions/workflows/ci.yml)
[![Coverage](https://codecov.io/gh/bpolaszek/meilisearch-filters-php/branch/master/graph/badge.svg?token=L5ulTaymbt)](https://codecov.io/gh/bpolaszek/meilisearch-filters-php)
[![Total Downloads](https://poser.pugx.org/bentools/meilisearch-filters/downloads)](https://packagist.org/packages/bentools/meilisearch-filters)

# MeiliSearch Filter Builder

This library allows you to build [Meilisearch filters](https://www.meilisearch.com/docs/learn/fine_tuning_results/filtering#filter-basics) using PHP.

This is a port of the [JS library](https://github.com/bpolaszek/meilisearch-filters).

Examples:

### Comparison Filters

```php
use function Bentools\MeilisearchFilters\field;

echo field('cat')->equals("Berlioz"); // cat = 'Berlioz'
echo field('cat')->notEquals("O'Malley"); // cat != 'O\\'Malley'
echo field('age')->isGreaterThan(5); // age > '5'
echo field('age')->isGreaterThan(5, true); // age >= '5'
echo field('age')->isNotGreaterThan(5); // age <= '5'
echo field('age')->isNotGreaterThan(5, true); // age < '5'
echo field('age')->isLowerThan(10); // age < '10'
echo field('age')->isLowerThan(10, true); // age <= '10'
echo field('age')->isNotLowerThan(10); // age >= '10'
echo field('age')->isNotLowerThan(10, true); // age > '10'
```

### Between Filter

```php
use function Bentools\MeilisearchFilters\field;

echo field('age')->isBetween(5, 10); // age '5' TO '10'
echo field('age')->isNotBetween(5, 10); // NOT age '5' TO '10'
echo field('age')->isBetween(5, 10, false); // age > '5' AND age < '10'
echo field('age')->isNotBetween(5, 10, false); // NOT (age > '5' AND age < '10')
```

### Exists Filter

```php
use function Bentools\MeilisearchFilters\field;

echo field('god')->exists(); // god EXISTS
echo field('god')->doesNotExist(); // god NOT EXISTS
```

### Empty Filter

```php
use function Bentools\MeilisearchFilters\field;

echo field('glass')->isEmpty(); // glass IS EMPTY
echo field('glass')->isNotEmpty(); // glass IS NOT EMPTY
```

### Null Filter

```php
use function Bentools\MeilisearchFilters\field;

echo field('nullish')->isNull(); // nullish IS NULL
echo field('nullish')->isNotNull(); // nullish IS NOT NULL
```

### IN Filter

```php
use function Bentools\MeilisearchFilters\field;

$cat = field('cat')
echo $cat->isIn(['Berlioz', "O'Malley"]); // cat IN ['Berlioz', 'O\\'Malley']
echo $cat->isNotIn(['Berlioz', "O'Malley"]); // cat NOT IN ['Berlioz', 'O\\'Malley']
```

### CONTAINS filter

```php
use function Bentools\MeilisearchFilters\field;

$cat = field('cat')
echo $cat->contains('Berlioz'); // cat CONTAINS 'Berlioz'
echo $cat->doesNotContain('Berlioz'); // cat NOT CONTAINS 'Berlioz'
```

### STARTS WITH filter

```php
use function Bentools\MeilisearchFilters\field;

$cat = field('cat')
echo $cat->startWith('Ber'); // cat STARTS WITH 'Ber'
echo $cat->doesNotStartWith('Ber'); // cat NOT STARTS WITH 'Ber'
```

### Geographic filters

```php
use function Bentools\MeilisearchFilters\{withinGeoRadius, notWithinGeoRadius};

echo withinGeoRadius(50.35, 3.51, 3000); // _geoRadius(50.35, 3.51, 3000)
echo notWithinGeoRadius(50.35, 3.51, 3000); // NOT _geoRadius(50.35, 3.51, 3000)
```

```php
use function Bentools\MeilisearchFilters\{withinGeoBoundingBox, notWithinGeoBoundingBox};

echo withinGeoBoundingBox([50.55, 3], [50.52, 3.08]); // _geoBoundingBox([50.55, 3], [50.52, 3.08])
echo notWithinGeoBoundingBox([50.55, 3], [50.52, 3.08]); // NOT _geoBoundingBox([50.55, 3], [50.52, 3.08])
```

### Composite filters

```php
use function Bentools\MeilisearchFilters\field;

$cat = field('cat')
$color = field('color')
$age = field('age')
echo $cat->equals("Berlioz")->and($age->between(5, 10)); // cat = 'Berlioz' AND age '5' TO '10'
echo $cat->equals("Berlioz")->or($age->between(5, 10)); // cat = 'Berlioz' OR age '5' TO '10'

// Automatic grouping
echo $color->equals('ginger')->or($cat->equals("Berlioz")->and($age->between(5, 10))); // color = 'ginger' OR (cat = 'Berlioz' AND age '5' TO '10')
```

### NOT filter

```php
use function Bentools\MeilisearchFilters\{field, not};

$color = field('ginger')
echo not($color->equals('ginger')); // NOT color = 'ginger' 
```

### Adding parentheses

```php
use function Bentools\MeilisearchFilters\{field, group};

$color = field('ginger')
echo group($color->equals('ginger')); // (color = 'ginger') 
```

# Installation

```
composer req bentools/meilisearch-filters
```

# Tests

```
composer ci:check
```

# License

MIT.
