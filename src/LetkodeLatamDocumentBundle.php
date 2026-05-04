<?php

declare(strict_types=1);

namespace Letkode\LatamDocument;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class LetkodeLatamDocumentBundle extends AbstractBundle implements PrependExtensionInterface
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $services = $container->services();

        $services->set(DocumentFactory::class)
            ->autowire()
            ->autoconfigure();

        $services->set(DocumentProcessor::class)
            ->autowire()
            ->autoconfigure()
            ->arg('$translator', service('translator')->nullOnInvalidReference());
    }

    public function prepend(ContainerBuilder $container): void
    {
        if (!$container->hasExtension('framework')) {
            return;
        }

        $container->prependExtensionConfig('framework', [
            'translator' => [
                'paths' => [__DIR__ . '/Translations'],
            ],
        ]);
    }
}
