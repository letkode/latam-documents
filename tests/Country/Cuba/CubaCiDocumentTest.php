<?php

declare(strict_types=1);

namespace Letkode\LatamDocument\Tests\Country\Cuba;

use Letkode\LatamDocument\Country\Cuba\CubaCiDocument;
use Letkode\LatamDocument\Enum\CountryDocumentEnum;
use Letkode\LatamDocument\Enum\DocumentTypeEnum;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CubaCiDocumentTest extends TestCase
{
    private CubaCiDocument $doc;

    protected function setUp(): void
    {
        $this->doc = new CubaCiDocument();
    }

    public function testGetCountry(): void
    {
        self::assertSame(CountryDocumentEnum::CU, $this->doc->getCountry());
    }

    public function testGetType(): void
    {
        self::assertSame(DocumentTypeEnum::CI, $this->doc->getType());
    }

    #[DataProvider('validCis')]
    public function testIsValidReturnsTrue(string $raw): void
    {
        self::assertTrue($this->doc->isValid($raw));
    }

    #[DataProvider('invalidCis')]
    public function testIsValidReturnsFalse(string $raw): void
    {
        self::assertFalse($this->doc->isValid($raw));
    }

    public function testNormalizeStripsNonDigits(): void
    {
        self::assertSame('90011512345', $this->doc->normalize('90011512345'));
    }

    public function testFormatReturnsNormalized(): void
    {
        self::assertSame('90011512345', $this->doc->format('90011512345'));
    }

    public static function validCis(): array
    {
        return [
            'YYMMDD valido'       => ['90011512345'],
            'otro valido'         => ['85063012345'],
            'nacido en enero'     => ['00010112345'],
            'nacido en diciembre' => ['95123112345'],
        ];
    }

    public static function invalidCis(): array
    {
        return [
            'vacio'           => [''],
            'mes invalido 00' => ['90001512345'],
            'mes invalido 13' => ['90131512345'],
            'dia invalido 00' => ['90010012345'],
            'muy corto'       => ['9001151234'],
        ];
    }
}
