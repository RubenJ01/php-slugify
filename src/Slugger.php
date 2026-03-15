<?php

namespace Rjds\PhpSlugify;

use RuntimeException;
use Transliterator;

class Slugger implements SluggerInterface
{
    private Transliterator $transliterator;

    /** @var array<string, string> */
    private array $localeMappings;

    /**
     * @param Transliterator $transliterator
     * @param array<string, string> $localeMappings
     */
    public function __construct(Transliterator $transliterator, array $localeMappings = [])
    {
        $this->transliterator = $transliterator;
        $this->localeMappings = $localeMappings;
    }

    /**
     * @param string $text
     * @param string $divider
     * @param array<string, string> $mappings
     * @param string $emptyValue
     * @param int|null $maxLength
     * @return string
     */
    public function slugify(
        string $text,
        string $divider = '-',
        array $mappings = [],
        string $emptyValue = '',
        ?int $maxLength = null
    ): string {
        if ($text === '') {
            return $emptyValue;
        }

        $mergedMappings = array_merge($this->localeMappings, $mappings);

        if ($mergedMappings !== []) {
            $text = str_replace(array_keys($mergedMappings), $mergedMappings, $text);
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
        $slug = str_replace(' ', $divider, $text);

        if ($maxLength !== null && strlen($slug) > $maxLength) {
            $slug = substr($slug, 0, $maxLength);
            $lastDivider = strrpos($slug, $divider);

            if ($lastDivider !== false) {
                $slug = substr($slug, 0, $lastDivider);
            }

            $slug = rtrim($slug, $divider);
        }

        return $slug;
    }
}
