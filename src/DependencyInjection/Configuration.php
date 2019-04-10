<?php

declare(strict_types=1);

namespace Lamoda\TacticianQueueBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('lamoda_tactician_queue');

        $rootNode
            ->children()
                ->scalarNode('tactician_id')
                    ->defaultValue('tactician.commandbus')
                    ->info('Id of the tactician command bus service')
                ->end()
                ->scalarNode('command_serializer_id')
                    ->defaultValue('lamoda_tactician_queue.default_command_serializer')
                    ->info('Id of the Symfony serializer service used for command serialization')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
