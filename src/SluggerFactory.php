<?php

namespace Rjds\PhpSlugify;

use RuntimeException;
use Transliterator;

class SluggerFactory
{
    public static function create(): SluggerInterface
    {
        $transliterator = Transliterator::create('Any-Latin; Latin-ASCII;');

        if ($transliterator === null) {
            throw new RuntimeException("Transliterator can't be created");
        }

        return new Slugger($transliterator);
    }
}
