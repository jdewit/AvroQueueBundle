<?php

namespace Avro\QueueBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
* Contains the configuration information for the bundle
*
* @author Joris de Wit <joris.w.dewit@gmail.com>
*/
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('avro_queue');

        $rootNode
            ->children()
                ->scalarNode('fallback_route')->isRequired()->cannotBeEmpty()->end()
                ->booleanNode('use_referer')->defaultTrue()->end()
            ->end();

        return $treeBuilder;
    }

}
