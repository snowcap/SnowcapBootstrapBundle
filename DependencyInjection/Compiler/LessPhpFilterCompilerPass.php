<?php

namespace Snowcap\BootstrapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LessPhpFilterCompilerPass implements CompilerPassInterface {
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('assetic.filter.lessphp')) {
            return;
        }

        $definition = $container->getDefinition('assetic.filter.lessphp');
        $rootDir = $container->getParameter('kernel.root_dir');
        $definition->addMethodCall('addLoadPath', array(realpath($rootDir . '/../web')));
    }
}
