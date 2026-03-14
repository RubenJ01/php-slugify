# PHP Slugify

![Version](https://img.shields.io/github/v/release/RubenJ01/php-slugify?label=version)
[![codecov](https://codecov.io/github/RubenJ01/php-slugify/graph/badge.svg)](https://codecov.io/github/RubenJ01/php-slugify)
[![status-badge](https://ci.rubenjakob.com/api/badges/1/status.svg)](https://ci.rubenjakob.com/repos/1)
![License](https://img.shields.io/github/license/RubenJ01/php-slugify)

A PHP library to convert a string into a clean URL-safe lowercase string.

## Installation

Add these lines to your composer.json file, or add a new repository URL if you already have one or more:

```json
{
    "repositories": [
        {"type": "composer", "url": "https://ruben-jakob-digital-solutions.repo.repman.rubenjakob.com"}
    ]
}
```

Then require the package:

```bash
composer require rjds/php-slugify
```

## Usage

Getting started with php-slugify is simple.

### Basic Example

```php
use Rjds\PhpSlugify\SluggerFactory;

$slugger = SluggerFactory::create();

// Outputs: hello-world-2026
echo $slugger->slugify('Hello World 2026!');
```

### Customizing the Divider
You can change the default hyphen to any other character:

```php
// Outputs: hello_world_2026
echo $slugger->slugify('Hello World 2026', '_');
```

### Custom Character Mapping
You can pass an associative array of custom character replacements via the `mappings` parameter. Mappings are applied before transliteration, enabling domain-specific replacements:

```php
// Outputs: tom-and-jerry
echo $slugger->slugify('Tom & Jerry', mappings: ['&' => 'and']);

// Outputs: contact-at-example-dot-com
echo $slugger->slugify('contact@example.com', mappings: ['@' => ' at ', '.' => ' dot ']);

// Combine with a custom divider
// Outputs: price_10_eur
echo $slugger->slugify('Price 10€', divider: '_', mappings: ['€' => ' eur']);
```

### Language-Aware Transliteration
By default, the slugger uses generic Unicode-to-ASCII transliteration. For languages with specific conventions, pass a locale to `SluggerFactory::create()`:

```php
// German: ü → ue, ö → oe, ä → ae, ß → ss
$slugger = SluggerFactory::create('de');

// Outputs: ueber-die-bruecke
echo $slugger->slugify('Über die Brücke');

// Outputs: strasse
echo $slugger->slugify('Straße');
```

```php
// Turkish: ı → i, İ → I, ş → s, ç → c, ğ → g
$slugger = SluggerFactory::create('tr');

// Outputs: istanbul
echo $slugger->slugify('İstanbul');
```

Supported locales: `de` (German), `tr` (Turkish).

User-provided `mappings` override locale mappings when both define the same character:

```php
$slugger = SluggerFactory::create('de');

// Outputs: u-boot (user mapping Ü → U overrides locale Ü → Ue)
echo $slugger->slugify('Ü-Boot', mappings: ['Ü' => 'U']);
```

### Empty Input Handling
By default, an empty string input returns an empty string. You can customize this with the `emptyValue` parameter:

```php
// Outputs: (empty string)
echo $slugger->slugify('');

// Outputs: n-a
echo $slugger->slugify('', emptyValue: 'n-a');
```