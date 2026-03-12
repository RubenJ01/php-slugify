<?php

namespace Rjds\PhpSlugify;

interface SluggerInterface
{
    public function slugify(string $text, string $divider = '-'): string;
}
