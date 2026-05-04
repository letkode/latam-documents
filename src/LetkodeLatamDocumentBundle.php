<?php

declare(strict_types=1);

namespace Letkode\LatamDocument;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class LetkodeLatamDocumentBundle extends AbstractBundle implements PrependExtensionInterface
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $builder->autowire(DocumentFactory::class)->setPublic(false);

        $builder->autowire(DocumentProcessor::class)
            ->setPublic(false)
            ->setArgument('$translator', new Reference('translator', ContainerBuilder::NULL_ON_INVALID_REFERENCE));
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
