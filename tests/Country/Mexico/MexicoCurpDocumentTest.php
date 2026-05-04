<?php

declare(strict_types=1);

namespace Letkode\LatamDocument\Tests\Country\Mexico;

use Letkode\LatamDocument\Country\Mexico\MexicoCurpDocument;
use Letkode\LatamDocument\Enum\CountryDocumentEnum;
use Letkode\LatamDocument\Enum\DocumentTypeEnum;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MexicoCurpDocumentTest extends TestCase
{
    private MexicoCurpDocument $doc;

    protected function setUp(): void
    {
        $this->doc = new MexicoCurpDocument();
    }

    public function testGetCountry(): void
    {
        self::assertSame(CountryDocumentEnum::MX, $this->doc->getCountry());
    }

    public function testGetType(): void
    {
        self::assertSame(DocumentTypeEnum::CURP, $this->doc->getType());
    }

    #[DataProvider('validCurps')]
    public function testIsValidReturnsTrue(string $raw): void
    {
        self::assertTrue($this->doc->isValid($raw));
    }

    #[DataProvider('invalidCurps')]
    public function testIsValidReturnsFalse(string $raw): void
    {
        self::assertFalse($this->doc->isValid($raw));
    }

    public function testNormalizeUppercase(): void
    {
        self::assertSame('BADD110313HCMLNS09', $this->doc->normalize('badd110313hcmlns09'));
    }

    public function testFormatReturnsNormalized(): void
    {
        self::assertSame('BADD110313HCMLNS09', $this->doc->format('BADD110313HCMLNS09'));
    }

    public static function validCurps(): array
    {
        return [
            'masculino colima' => ['BADD110313HCMLNS09'],
            'femenino veracruz' => ['HEGG560427MVZRRL04'],
            'estado NE' => ['AAAA800101HNELNN09'],
            'otro valido' => ['GODE561231HOCMNS09'],
        ];
    }

    public static function invalidCurps(): array
    {
        return [
            'vacio' => [''],
            'muy corto' => ['BADD110313HCMLNS0'],
            'mes invalido' => ['BADD111313HCMLNS09'],
            'estado invalido' => ['BADD110313HXXLNS09'],
            'sin vocal inicial' => ['BBDD110313HCMLNS09'],
        ];
    }
}
