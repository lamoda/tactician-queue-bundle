<?php

namespace Lamoda\TacticianQueueBundle;

use Lamoda\TacticianQueueBundle\DependencyInjection\CompilerPass\TacticianMiddlewareCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LamodaTacticianQueueBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TacticianMiddlewareCompilerPass());
    }
}
