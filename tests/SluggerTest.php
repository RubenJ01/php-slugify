<?php

namespace Rjds\PhpSlugify\Tests;

use PHPUnit\Framework\TestCase;
use Rjds\PhpSlugify\Slugger;
use Rjds\PhpSlugify\SluggerFactory;
use RuntimeException;
use Transliterator;

class SluggerTest extends TestCase
{
    private Slugger $slugger;

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

    public function testItHandlesEmptyInput(): void
    {
        $this->assertEquals('n-a', $this->slugger->slugify(''));
    }

    public function testItThrowsExceptionWhenTransliterationFails(): void
    {
        $mock = $this->createMock(Transliterator::class);
        $mock->method('transliterate')->willReturn(false);

        $slugger = new Slugger($mock);

        $this->expectException(RuntimeException::class);

        $slugger->slugify('test');
    }

    public function testItThrowsExceptionWhenPregReplaceFails(): void
    {
        $this->expectException(RuntimeException::class);

        $this->slugger->slugify("\xFF\xFF\xFF");
    }
}
