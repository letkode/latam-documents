<?php

declare(strict_types=1);

namespace Letkode\LatamDocument\Bundle\DependencyInjection;

use Letkode\LatamDocument\DocumentFactory;
use Letkode\LatamDocument\DocumentProcessor;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class LatamDocumentExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $factory = new Definition(DocumentFactory::class);
        $factory->setAutowired(true)->setAutoconfigured(true)->setPublic(false);
        $container->setDefinition(DocumentFactory::class, $factory);

        $processor = new Definition(DocumentProcessor::class);
        $processor->setArguments([
            new Reference(DocumentFactory::class),
            new Reference('translator', ContainerBuilder::NULL_ON_INVALID_REFERENCE),
        ]);
        $processor->setAutowired(true)->setAutoconfigured(true)->setPublic(false);
        $container->setDefinition(DocumentProcessor::class, $processor);

        $container->addResource(new FileResource(\dirname(__DIR__, 2) . '/Translations'));
    }

    public function getAlias(): string
    {
        return 'latam_document';
    }
}
