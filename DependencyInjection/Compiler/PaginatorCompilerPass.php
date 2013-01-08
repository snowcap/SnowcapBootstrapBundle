<?php

namespace Snowcap\BootstrapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PaginatorCompilerPass implements CompilerPassInterface {
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('snowcap_core.twig_paginator')) {
            return;
        }

        $definition = $container->getDefinition('snowcap_core.twig_paginator');
        $definition->addMethodCall('addTemplatePath', array(__DIR__ . '/../../Resources/views/Paginator'));
    }
}