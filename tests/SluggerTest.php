<?php

namespace Rjds\PhpSlugify\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Rjds\PhpSlugify\Slugger;
use Rjds\PhpSlugify\SluggerFactory;
use Rjds\PhpSlugify\SluggerInterface;
use RuntimeException;
use Transliterator;

class SluggerTest extends TestCase
{
    private SluggerInterface $slugger;

    protected function setUp(): void
    {
        $this->slugger = SluggerFactory::create();
    }

    public function testItConvertsSimpleStringsToSlugs(): void
    {
        $this->assertEquals('hello-world', $this->slugger->slugify('Hello World'));
    }

    public function testItReplacesSpacesWithCustomDivider(): void
    {
        $this->assertEquals('hello_world', $this->slugger->slugify('Hello World', '_'));
    }

    public function testItHandlesSpecialCharactersAndAccents(): void
    {
        $this->assertEquals('naive-cafe', $this->slugger->slugify('naïve café'));
    }

    public function testItRemovesUnwantedPunctuation(): void
    {
        $this->assertEquals('this-is-a-test', $this->slugger->slugify('This is a test!!! ???'));
    }

    public function testItReturnsEmptyStringByDefault(): void
    {
        $this->assertEquals('', $this->slugger->slugify(''));
    }

    public function testItReturnsCustomEmptyValue(): void
    {
        $this->assertEquals('n-a', $this->slugger->slugify('', emptyValue: 'n-a'));
    }

    public function testItThrowsExceptionWhenTransliterationFails(): void
    {
        $stub = $this->createStub(Transliterator::class);
        $stub->method('transliterate')->willReturn(false);

        $slugger = new Slugger($stub);

        $this->expectException(RuntimeException::class);

        $slugger->slugify('test');
    }

    public function testItThrowsExceptionWhenPregReplaceFails(): void
    {
        $this->expectException(RuntimeException::class);

        $this->slugger->slugify("\xFF\xFF\xFF");
    }

    public function testItAppliesCustomCharacterMappings(): void
    {
        $this->assertEquals(
            'tom-and-jerry',
            $this->slugger->slugify('Tom & Jerry', mappings: ['&' => 'and'])
        );
    }

    public function testItAppliesMultipleCustomMappings(): void
    {
        $this->assertEquals(
            'contact-at-example-dot-com',
            $this->slugger->slugify('contact@example.com', mappings: ['@' => ' at ', '.' => ' dot '])
        );
    }

    public function testItAppliesCustomMappingsWithCustomDivider(): void
    {
        $this->assertEquals(
            'price_10_eur',
            $this->slugger->slugify('Price 10€', divider: '_', mappings: ['€' => ' eur'])
        );
    }

    public function testItHandlesEmptyMappingsArray(): void
    {
        $this->assertEquals(
            'hello-world',
            $this->slugger->slugify('Hello World', mappings: [])
        );
    }

    public function testItTransliteratesGermanCharacters(): void
    {
        $slugger = SluggerFactory::create('de');
        $this->assertEquals('ueber-die-bruecke', $slugger->slugify('Über die Brücke'));
    }

    public function testItTransliteratesGermanEszett(): void
    {
        $slugger = SluggerFactory::create('de');
        $this->assertEquals('strasse', $slugger->slugify('Straße'));
    }

    public function testItTransliteratesTurkishCharacters(): void
    {
        $slugger = SluggerFactory::create('tr');
        $this->assertEquals('istanbul', $slugger->slugify('İstanbul'));
    }

    public function testItTransliteratesTurkishDotlessI(): void
    {
        $slugger = SluggerFactory::create('tr');
        $this->assertEquals('isik', $slugger->slugify('ışık'));
    }

    public function testLocaleSluggerStillAcceptsUserMappings(): void
    {
        $slugger = SluggerFactory::create('de');
        $this->assertEquals(
            'preis-10-eur',
            $slugger->slugify('Preis 10€', mappings: ['€' => ' eur'])
        );
    }

    public function testUserMappingsOverrideLocaleMappings(): void
    {
        $slugger = SluggerFactory::create('de');
        $this->assertEquals(
            'u-boot',
            $slugger->slugify('Ü-Boot', mappings: ['Ü' => 'U'])
        );
    }

    public function testFactoryWithoutLocaleStillWorks(): void
    {
        $slugger = SluggerFactory::create();
        $this->assertEquals('hello-world', $slugger->slugify('Hello World'));
    }

    public function testFactoryThrowsExceptionForUnsupportedLocale(): void
    {
        $this->expectException(InvalidArgumentException::class);
        SluggerFactory::create('xx');
    }

    public function testItTruncatesSlugToMaxLength(): void
    {
        $this->assertEquals(
            'hello',
            $this->slugger->slugify('Hello World', maxLength: 8)
        );
    }

    public function testItTruncatesOnWordBoundary(): void
    {
        $this->assertEquals(
            'the-quick',
            $this->slugger->slugify('The Quick Brown Fox', maxLength: 14)
        );
    }

    public function testItReturnsFullSlugWhenUnderMaxLength(): void
    {
        $this->assertEquals(
            'hello-world',
            $this->slugger->slugify('Hello World', maxLength: 50)
        );
    }

    public function testItReturnsFullSlugWhenExactlyMaxLength(): void
    {
        $this->assertEquals(
            'hello-world',
            $this->slugger->slugify('Hello World', maxLength: 11)
        );
    }

    public function testMaxLengthWithSingleWordExceedingLimit(): void
    {
        $this->assertEquals(
            'super',
            $this->slugger->slugify('Supercalifragilistic', maxLength: 5)
        );
    }

    public function testMaxLengthWithCustomDivider(): void
    {
        $this->assertEquals(
            'hello_world',
            $this->slugger->slugify('Hello World 2026', '_', maxLength: 15)
        );
    }

    public function testMaxLengthWithNullDoesNotTruncate(): void
    {
        $this->assertEquals(
            'hello-world',
            $this->slugger->slugify('Hello World', maxLength: null)
        );
    }

    public function testMaxLengthTrimsTrailingDividerAfterTruncation(): void
    {
        $this->assertEquals(
            'a',
            $this->slugger->slugify('a  b c', maxLength: 4)
        );
    }
}
