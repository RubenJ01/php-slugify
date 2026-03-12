# PHP Slugify

A PHP library to convert a string into a clean URL-safe lowercase string.

## Usage

Getting started with php-slugify is simple.

### Basic Example

```php
use Rjds\PhpSlugify\Slugger;

$slugger = new Slugger();

// Outputs: hello-world-2026
echo $slugger->slugify('Hello World 2026!');
```

### Customizing the Divider
You can change the default hyphen to any other character:

```php
// Outputs: hello_world_2026
echo $slugger->slugify('Hello World 2026', '_');
```
