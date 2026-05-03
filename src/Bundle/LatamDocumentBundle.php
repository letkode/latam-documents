<?php

declare(strict_types=1);

namespace Letkode\LatamDocument\Bundle;

use Letkode\LatamDocument\Bundle\DependencyInjection\LatamDocumentExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class LatamDocumentBundle extends Bundle
{
    public function getContainerExtension(): LatamDocumentExtension
    {
        return new LatamDocumentExtension();
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
