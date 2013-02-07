<?php

namespace Symfony\Cmf\Bundle\BlogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
* This class contains the configuration information for the bundle
*
* This information is solely responsible for how the different configuration
* sections are normalized, and merged.
*
* @author David Buchmann
*/
class Configuration implements ConfigurationInterface
{
    /**
     * Returns the config tree builder.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('symfony_cmf_blog')
            ->children()
            ->scalarNode('blog_basepath')
                ->defaultValue('/cms/content')
            ->end()
            ->scalarNode('routing_post_controller')
                ->defaultValue('symfony_cmf_blog.blog_controller:viewPost')
            ->end()
            ->scalarNode('routing_post_prefix')
                ->defaultValue('posts')
            ->end()
            ->scalarNode('routing_basepath')
                ->isRequired()
            ->end()
        ;

        return $treeBuilder;
    }
}
