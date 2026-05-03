<?php

declare(strict_types=1);

namespace Letkode\LatamDocument;

use Letkode\LatamDocument\DTO\DocumentResultDTO;
use Letkode\LatamDocument\Enum\CountryDocumentEnum;
use Letkode\LatamDocument\Enum\DocumentTypeEnum;
use Letkode\LatamDocument\Exception\InvalidDocumentException;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class DocumentProcessor
{
    public function __construct(
        private DocumentFactory      $factory    = new DocumentFactory(),
        private ?TranslatorInterface $translator = null,
    ) {
    }

    public function process(string $raw, CountryDocumentEnum $country, DocumentTypeEnum $type): DocumentResultDTO
    {
        $doc   = $this->factory->make($country, $type);
        $valid = $doc->isValid($raw);

        $message = $valid ? null : $this->translateInvalid($raw, $country, $type);

        return new DocumentResultDTO(
            country:    $country,
            type:       $type,
            raw:        $raw,
            normalized: $doc->normalize($raw),
            formatted:  $doc->format($raw),
            valid:      $valid,
            message:    $message,
        );
    }

    public function processOrFail(string $raw, CountryDocumentEnum $country, DocumentTypeEnum $type): DocumentResultDTO
    {
        $result = $this->process($raw, $country, $type);

        if (!$result->valid) {
            throw new InvalidDocumentException($raw, $country, $type, $result->message ?? '');
        }

        return $result;
    }

    private function translateInvalid(string $raw, CountryDocumentEnum $country, DocumentTypeEnum $type): string
    {
        if (null === $this->translator) {
            return \sprintf('Document "%s" is not valid for %s/%s', $raw, $country->value, $type->value);
        }

        return $this->translator->trans(
            'document.invalid',
            ['%document%' => $raw, '%country%' => $country->value, '%type%' => $type->value],
            'latam_documents',
        );
    }
}
