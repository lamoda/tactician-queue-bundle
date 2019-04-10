<?php

declare(strict_types=1);

namespace Lamoda\TacticianQueueBundle\DependencyInjection\CompilerPass;

use Lamoda\TacticianQueue\Middleware\QueueProducerStrategy\ChainedStrategy;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class TacticianMiddlewareCompilerPass implements CompilerPassInterface
{
    private const QUEUE_PRODUCER_CHAIN_STRATEGY = ChainedStrategy::class;
    private const TACTICIAN_MIDDLEWARE_STRATEGY_TAG = 'tactician_queue.job_producing_strategy';

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(static::QUEUE_PRODUCER_CHAIN_STRATEGY)) {
            return;
        }

        $chainDefinition = $container->getDefinition(static::QUEUE_PRODUCER_CHAIN_STRATEGY);

        foreach ($container->findTaggedServiceIds(self::TACTICIAN_MIDDLEWARE_STRATEGY_TAG) as $serviceId => $tags) {
            $chainDefinition->addMethodCall('addStrategy', [new Reference($serviceId)]);
        }
    }
}
