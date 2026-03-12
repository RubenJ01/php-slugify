<?php

namespace Rjds\PhpSlugify;

use http\Exception\RuntimeException;
use Transliterator;

class Slugger
{
    /**
     * Converts a string into a clean URL-safe lowercase string
     *
     * @param string $text
     * @param string $divider
     * @return string
     */
    public function slugify(string $text, string $divider = '-'): string
    {
        if ($text === '') {
            return 'n-a';
        }

        $text = strtolower($text);

        $transliterator = Transliterator::create('Any-Latin; Latin-ASCII;');
        if ($transliterator === null) {
            throw new RuntimeException("Failed to create Transliterator");
        }

        $text = $transliterator->transliterate($text);
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
