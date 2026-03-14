# PHP Slugify

![Version](https://img.shields.io/github/v/release/RubenJ01/php-slugify?label=version)
[![codecov](https://codecov.io/github/RubenJ01/php-slugify/graph/badge.svg)](https://codecov.io/github/RubenJ01/php-slugify)
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

### Empty Input Handling
By default, an empty string input returns an empty string. You can customize this with the `emptyValue` parameter:

```php
// Outputs: (empty string)
echo $slugger->slugify('');

// Outputs: n-a
echo $slugger->slugify('', emptyValue: 'n-a');
```