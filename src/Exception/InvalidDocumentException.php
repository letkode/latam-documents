<?php

declare(strict_types=1);

namespace Letkode\LatamDocument\Exception;

use Letkode\LatamDocument\Enum\CountryDocumentEnum;
use Letkode\LatamDocument\Enum\DocumentTypeEnum;

final class InvalidDocumentException extends DocumentException
{
    public function __construct(
        public readonly string $raw,
        public readonly CountryDocumentEnum $country,
        public readonly DocumentTypeEnum $type,
        string $message = '',
    ) {
        parent::__construct($message ?: \sprintf(
            'Document "%s" is not valid for %s/%s',
            $raw,
            $country->value,
            $type->value,
        ));
    }
}