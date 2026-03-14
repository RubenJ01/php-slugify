<?php

namespace Rjds\PhpSlugify;

interface SluggerInterface
{
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
    ): string;
}
