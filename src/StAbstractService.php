<?php

namespace St\AbstractService;

use St\AbstractService\DependencyInjection\StAbstractServiceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class StAbstractService extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void
    {

    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new StAbstractServiceExtension();
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}