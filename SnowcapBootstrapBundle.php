<?php

namespace Snowcap\BootstrapBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Snowcap\BootstrapBundle\DependencyInjection\Compiler\PaginatorCompilerPass;
use Snowcap\BootstrapBundle\DependencyInjection\Compiler\LessPhpFilterCompilerPass;

class SnowcapBootstrapBundle extends Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new PaginatorCompilerPass());
        $container->addCompilerPass(new LessPhpFilterCompilerPass());
    }
}
