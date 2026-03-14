<?php

namespace Rjds\PhpSlugify;

use InvalidArgumentException;
use RuntimeException;
use Transliterator;

class SluggerFactory
{
    /**
     * Locale-specific character mappings applied before transliteration.
     *
     * @var array<string, array<string, string>>
     */
    private const LOCALE_MAPPINGS = [
        'de' => [
            'Ä' => 'Ae', 'ä' => 'ae',
            'Ö' => 'Oe', 'ö' => 'oe',
            'Ü' => 'Ue', 'ü' => 'ue',
            'ß' => 'ss',
        ],
        'tr' => [
            'ı' => 'i', 'İ' => 'I',
            'ş' => 's', 'Ş' => 'S',
            'ç' => 'c', 'Ç' => 'C',
            'ğ' => 'g', 'Ğ' => 'G',
            'ö' => 'o', 'Ö' => 'O',
            'ü' => 'u', 'Ü' => 'U',
        ],
    ];

    public static function create(?string $locale = null): SluggerInterface
    {
        $localeMappings = [];

        if ($locale !== null) {
            if (!isset(self::LOCALE_MAPPINGS[$locale])) {
                throw new InvalidArgumentException(
                    sprintf(
                        "Unsupported locale '%s'. Supported locales: %s",
                        $locale,
                        implode(', ', array_keys(self::LOCALE_MAPPINGS))
                    )
                );
            }

            $localeMappings = self::LOCALE_MAPPINGS[$locale];
        }

        $transliterator = Transliterator::create('Any-Latin; Latin-ASCII;');

        if ($transliterator === null) {
            throw new RuntimeException("Transliterator can't be created");
        }

        return new Slugger($transliterator, $localeMappings);
    }
}
