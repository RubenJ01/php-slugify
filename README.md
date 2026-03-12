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
