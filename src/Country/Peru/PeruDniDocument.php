<?php

declare(strict_types=1);

namespace Letkode\LatamDocument\Country\Peru;

use Letkode\LatamDocument\Contract\DocumentInterface;
use Letkode\LatamDocument\Enum\CountryDocumentEnum;
use Letkode\LatamDocument\Enum\DocumentTypeEnum;

final readonly class PeruDniDocument implements DocumentInterface
{
    public function getCountry(): CountryDocumentEnum
    {
        return CountryDocumentEnum::PE;
    }

    public function getType(): DocumentTypeEnum
    {
        return DocumentTypeEnum::DNI;
    }

    public function normalize(string $raw): string
    {
        return preg_replace('/\D/', '', mb_trim($raw));
    }

    public function isValid(string $raw): bool
    {
        return 1 === preg_match('/^\d{8}$/', $this->normalize($raw));
    }

    public function format(string $raw): string
    {
        return $this->normalize($raw);
    }
}
