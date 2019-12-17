<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class TemplateExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('t3g.template.config', $config);
        $container->setParameter('t3g.template.config.menu.class', $config['application']['menu']['class']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        if ($container->hasExtension('knp_menu')) {
            $container->prependExtensionConfig(
                'knp_menu',
                [
                    'twig' => [
                        'template' => '@Template/menu/navbar.html.twig'
                    ]
                ]
            );
        }
        if ($container->hasExtension('knp_paginator')) {
            $container->prependExtensionConfig(
                'knp_paginator',
                [
                    'template' => [
                        'pagination' => '@Template/pagination/pagination.html.twig',
                        'sortable' => '@Template/pagination/sortable.html.twig'
                    ]
                ]
            );
        }
        if ($container->hasExtension('twig')) {
            $container->prependExtensionConfig(
                'twig',
                [
                    'form_themes' => ['bootstrap_4_layout.html.twig'],
                    'paths' => ['../Resources/views/overwrites']
                ]
            );
        }
    }
}
