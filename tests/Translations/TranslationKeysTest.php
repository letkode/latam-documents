<?php

declare(strict_types=1);

namespace Letkode\LatamDocument\Tests\Translations;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

final class TranslationKeysTest extends TestCase
{
    private const TRANSLATIONS_DIR = __DIR__ . '/../../src/Translations';

    public function testAllLocalesHaveSameKeys(): void
    {
        $locales = ['es', 'en', 'pt'];
        $keysByLocale = [];

        foreach ($locales as $locale) {
            $file = self::TRANSLATIONS_DIR . "/latam_documents.{$locale}.yaml";
            self::assertFileExists($file, "Missing translation file for locale: {$locale}");
            $keysByLocale[$locale] = array_keys(Yaml::parseFile($file));
            sort($keysByLocale[$locale]);
        }

        foreach ($locales as $locale) {
            self::assertSame(
                $keysByLocale['es'],
                $keysByLocale[$locale],
                "Translation keys mismatch between 'es' and '{$locale}'"
            );
        }
    }

    public function testNoEmptyTranslationValues(): void
    {
        foreach (['es', 'en', 'pt'] as $locale) {
            $data = Yaml::parseFile(self::TRANSLATIONS_DIR . "/latam_documents.{$locale}.yaml");
            foreach ($data as $key => $value) {
                self::assertNotEmpty($value, "Empty translation for key '{$key}' in locale '{$locale}'");
            }
        }
    }
}
