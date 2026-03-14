<?php

namespace Rjds\PhpSlugify;

use RuntimeException;
use Transliterator;

class Slugger implements SluggerInterface
{
    private Transliterator $transliterator;

    public function __construct(Transliterator $transliterator)
    {
        $this->transliterator = $transliterator;
    }

    /**
     * @param string $text
     * @param string $divider
     * @param array<string, string> $mappings
     * @param string $emptyValue
     * @return string
     */
    public function slugify(string $text, string $divider = '-', array $mappings = [], string $emptyValue = ''): string
    {
        if ($text === '') {
            return $emptyValue;
        }

        if ($mappings !== []) {
            $text = str_replace(array_keys($mappings), array_values($mappings), $text);
        }

        $text = strtolower($text);

        $text = $this->transliterator->transliterate($text);
        if ($text === false) {
            throw new RuntimeException("Failed to transliterate string");
        }

        $text = preg_replace('/[^A-Za-z0-9\-\s]/', '', $text);
        if ($text === null) {
            throw new RuntimeException("Something unexpected went wrong");
        }

        $text = trim($text);
        return str_replace(' ', $divider, $text);
    }
}
