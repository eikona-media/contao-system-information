<?php

/*
 * This file is part of System Information Bundle for Contao Open Source CMS.
 *
 * (c) eikona-media.de
 *
 * @license MIT
 */

namespace EikonaMedia\Contao\SystemInformation\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * Class EikonaMediaContaoSystemInformationExtension
 * @package EikonaMedia\Contao\SystemInformation\DependencyInjection
 */
class EikonaMediaContaoSystemInformationExtension extends ConfigurableExtension
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'eikona_media_contao_system_information';
    }

    /**
     * {@inheritdoc}
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('listener.yml');
        $loader->load('services.yml');
    }
}
