<?php

namespace Rjds\PhpSlugify;

interface SluggerInterface
{
    /**
     * @param string $text
     * @param string $divider
     * @param array<string, string> $mappings Custom character replacements applied before transliteration
     * @return string
     */
    public function slugify(string $text, string $divider = '-', array $mappings = []): string;
}
