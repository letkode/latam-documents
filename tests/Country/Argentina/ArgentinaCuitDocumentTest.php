<?php

declare(strict_types=1);

namespace Letkode\LatamDocument\Tests\Country\Argentina;

use Letkode\LatamDocument\Country\Argentina\ArgentinaCuitDocument;
use Letkode\LatamDocument\Enum\CountryDocumentEnum;
use Letkode\LatamDocument\Enum\DocumentTypeEnum;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ArgentinaCuitDocumentTest extends TestCase
{
    private ArgentinaCuitDocument $doc;

    protected function setUp(): void
    {
        $this->doc = new ArgentinaCuitDocument();
    }

    public function testGetCountry(): void
    {
        self::assertSame(CountryDocumentEnum::AR, $this->doc->getCountry());
    }

    public function testGetType(): void
    {
        self::assertSame(DocumentTypeEnum::CUIT, $this->doc->getType());
    }

    #[DataProvider('validCuits')]
    public function testIsValidReturnsTrue(string $raw): void
    {
        self::assertTrue($this->doc->isValid($raw));
    }

    #[DataProvider('invalidCuits')]
    public function testIsValidReturnsFalse(string $raw): void
    {
        self::assertFalse($this->doc->isValid($raw));
    }

    public function testNormalizeStripsNonDigits(): void
    {
        self::assertSame('20123456786', $this->doc->normalize('20-12345678-6'));
    }

    public function testFormatAddsDashes(): void
    {
        self::assertSame('20-12345678-6', $this->doc->format('20123456786'));
    }

    public static function validCuits(): array
    {
        return [
            'persona fisica prefijo 20' => ['20123456786'],
            'con guiones' => ['20-12345678-6'],
            'empresa prefijo 30 dv 1' => ['30123456781'],
            'empresa prefijo 33 dv 0' => ['33123456780'],
        ];
    }

    public static function invalidCuits(): array
    {
        return [
            'vacio' => [''],
            'digito verificador malo' => ['20123456787'],
            'menos de 11 digitos' => ['2012345678'],
            'mas de 11 digitos' => ['201234567860'],
        ];
    }
}
