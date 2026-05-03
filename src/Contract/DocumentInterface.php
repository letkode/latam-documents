<?php

declare(strict_types=1);

namespace Letkode\LatamDocument\Contract;

use Letkode\LatamDocument\Enum\CountryDocumentEnum;
use Letkode\LatamDocument\Enum\DocumentTypeEnum;

interface DocumentInterface
{
    public function isValid(string $raw): bool;

    public function format(string $raw): string;

    public function normalize(string $raw): string;

    public function getCountry(): CountryDocumentEnum;

    public function getType(): DocumentTypeEnum;
}
