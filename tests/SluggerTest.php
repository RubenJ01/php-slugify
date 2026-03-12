<?php

namespace Rjds\PhpSlugify\Tests;

use PHPUnit\Framework\TestCase;
use Rjds\PhpSlugify\Slugger;

class SluggerTest extends TestCase
{
    private Slugger $slugger;

    protected function setUp(): void
    {
        $this->slugger = new Slugger();
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
}
