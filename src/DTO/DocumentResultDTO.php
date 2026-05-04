<?php

declare(strict_types=1);

namespace Letkode\LatamDocument\DTO;

use Letkode\LatamDocument\Enum\CountryDocumentEnum;
use Letkode\LatamDocument\Enum\DocumentTypeEnum;

final readonly class DocumentResultDTO
{
    public function __construct(
        public CountryDocumentEnum $country,
        public DocumentTypeEnum $type,
        public string $raw,
        public string $normalized,
        public string $formatted,
        public bool $valid,
        public string|null $message = null,
    ) {
    }
}
