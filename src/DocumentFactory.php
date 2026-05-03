<?php

declare(strict_types=1);

namespace Letkode\LatamDocument;

use Letkode\LatamDocument\Contract\DocumentInterface;
use Letkode\LatamDocument\Country\Argentina\ArgentinaCuilDocument;
use Letkode\LatamDocument\Country\Argentina\ArgentinaCuitDocument;
use Letkode\LatamDocument\Country\Argentina\ArgentinaDniDocument;
use Letkode\LatamDocument\Country\Bolivia\BoliviaCiDocument;
use Letkode\LatamDocument\Country\Brazil\BrazilCnpjDocument;
use Letkode\LatamDocument\Country\Brazil\BrazilCpfDocument;
use Letkode\LatamDocument\Country\Chile\ChileRutDocument;
use Letkode\LatamDocument\Country\Colombia\ColombiaCcDocument;
use Letkode\LatamDocument\Country\Colombia\ColombiaNitDocument;
use Letkode\LatamDocument\Country\CostaRica\CostaRicaCiDocument;
use Letkode\LatamDocument\Country\CostaRica\CostaRicaDimexDocument;
use Letkode\LatamDocument\Country\Cuba\CubaCiDocument;
use Letkode\LatamDocument\Country\DominicanRepublic\DominicanRepublicCedulaDocument;
use Letkode\LatamDocument\Country\Ecuador\EcuadorCiDocument;
use Letkode\LatamDocument\Country\Ecuador\EcuadorRucDocument;
use Letkode\LatamDocument\Country\ElSalvador\ElSalvadorDuiDocument;
use Letkode\LatamDocument\Country\Guatemala\GuatemalaDpiDocument;
use Letkode\LatamDocument\Country\Honduras\HondurasRnpDocument;
use Letkode\LatamDocument\Country\Mexico\MexicoCurpDocument;
use Letkode\LatamDocument\Country\Mexico\MexicoRfcDocument;
use Letkode\LatamDocument\Country\Nicaragua\NicaraguaCiDocument;
use Letkode\LatamDocument\Country\Panama\PanamaCiDocument;
use Letkode\LatamDocument\Country\Paraguay\ParaguayCiDocument;
use Letkode\LatamDocument\Country\Peru\PeruDniDocument;
use Letkode\LatamDocument\Country\Peru\PeruRucDocument;
use Letkode\LatamDocument\Country\Spain\SpainCifDocument;
use Letkode\LatamDocument\Country\Spain\SpainNieDocument;
use Letkode\LatamDocument\Country\Spain\SpainNifDocument;
use Letkode\LatamDocument\Country\Uruguay\UruguayCiDocument;
use Letkode\LatamDocument\Country\Venezuela\VenezuelaCiDocument;
use Letkode\LatamDocument\Country\Venezuela\VenezuelaRifDocument;
use Letkode\LatamDocument\Enum\CountryDocumentEnum;
use Letkode\LatamDocument\Enum\DocumentTypeEnum;
use Letkode\LatamDocument\Exception\UnsupportedDocumentException;

final readonly class DocumentFactory
{
    public function make(CountryDocumentEnum $country, DocumentTypeEnum $type): DocumentInterface
    {
        return match ([$country, $type]) {
            [CountryDocumentEnum::CL, DocumentTypeEnum::RUT] => new ChileRutDocument(),
            [CountryDocumentEnum::BR, DocumentTypeEnum::CPF] => new BrazilCpfDocument(),
            [CountryDocumentEnum::BR, DocumentTypeEnum::CNPJ] => new BrazilCnpjDocument(),
            [CountryDocumentEnum::AR, DocumentTypeEnum::DNI] => new ArgentinaDniDocument(),
            [CountryDocumentEnum::AR, DocumentTypeEnum::CUIL] => new ArgentinaCuilDocument(),
            [CountryDocumentEnum::AR, DocumentTypeEnum::CUIT] => new ArgentinaCuitDocument(),
            [CountryDocumentEnum::CO, DocumentTypeEnum::CC] => new ColombiaCcDocument(),
            [CountryDocumentEnum::CO, DocumentTypeEnum::NIT] => new ColombiaNitDocument(),
            [CountryDocumentEnum::MX, DocumentTypeEnum::CURP] => new MexicoCurpDocument(),
            [CountryDocumentEnum::MX, DocumentTypeEnum::RFC] => new MexicoRfcDocument(),
            [CountryDocumentEnum::PE, DocumentTypeEnum::DNI] => new PeruDniDocument(),
            [CountryDocumentEnum::PE, DocumentTypeEnum::RUC] => new PeruRucDocument(),
            [CountryDocumentEnum::UY, DocumentTypeEnum::CI] => new UruguayCiDocument(),
            [CountryDocumentEnum::EC, DocumentTypeEnum::CI] => new EcuadorCiDocument(),
            [CountryDocumentEnum::EC, DocumentTypeEnum::RUC] => new EcuadorRucDocument(),
            [CountryDocumentEnum::DO, DocumentTypeEnum::CEDULA] => new DominicanRepublicCedulaDocument(),
            [CountryDocumentEnum::SV, DocumentTypeEnum::DUI] => new ElSalvadorDuiDocument(),
            [CountryDocumentEnum::ES, DocumentTypeEnum::NIF] => new SpainNifDocument(),
            [CountryDocumentEnum::ES, DocumentTypeEnum::NIE] => new SpainNieDocument(),
            [CountryDocumentEnum::ES, DocumentTypeEnum::CIF] => new SpainCifDocument(),
            [CountryDocumentEnum::BO, DocumentTypeEnum::CI] => new BoliviaCiDocument(),
            [CountryDocumentEnum::PY, DocumentTypeEnum::CI] => new ParaguayCiDocument(),
            [CountryDocumentEnum::VE, DocumentTypeEnum::CI] => new VenezuelaCiDocument(),
            [CountryDocumentEnum::VE, DocumentTypeEnum::RIF] => new VenezuelaRifDocument(),
            [CountryDocumentEnum::CR, DocumentTypeEnum::CI] => new CostaRicaCiDocument(),
            [CountryDocumentEnum::CR, DocumentTypeEnum::DIMEX] => new CostaRicaDimexDocument(),
            [CountryDocumentEnum::GT, DocumentTypeEnum::DPI] => new GuatemalaDpiDocument(),
            [CountryDocumentEnum::HN, DocumentTypeEnum::RNP] => new HondurasRnpDocument(),
            [CountryDocumentEnum::NI, DocumentTypeEnum::CI] => new NicaraguaCiDocument(),
            [CountryDocumentEnum::PA, DocumentTypeEnum::CI] => new PanamaCiDocument(),
            [CountryDocumentEnum::CU, DocumentTypeEnum::CI] => new CubaCiDocument(),
            default => throw new UnsupportedDocumentException($country, $type),
        };
    }

    public function supports(CountryDocumentEnum $country, DocumentTypeEnum $type): bool
    {
        try {
            $this->make($country, $type);

            return true;
        } catch (UnsupportedDocumentException) {
            return false;
        }
    }
}
