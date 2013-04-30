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
                ->enumNode('use_sonata_admin')
                    ->values(array(true, false, 'auto'))
                    ->defaultValue('auto')
                ->end()
                ->enumNode('integrate_menu')
                    ->values(array(true, false, 'auto'))
                    ->defaultValue('auto')
                ->end()
                ->scalarNode('blog_basepath')
                    ->isRequired()
                ->end()
                ->scalarNode('routing_post_controller')
                    ->defaultValue('symfony_cmf_blog.blog_controller:viewPostAction')
                ->end()
                ->scalarNode('routing_post_prefix')
                    ->defaultValue('posts')
                ->end()
                ->scalarNode('routing_tag_controller')
                    ->defaultValue('symfony_cmf_blog.blog_controller:listAction')
                ->end()
                ->scalarNode('routing_tag_prefix')
                    ->defaultValue('tag')
                ->end()
                ->arrayNode('class')
                    ->children()
                        # defaults defined in SymfonyCmfBlogExtension
                        ->scalarNode('blog_admin')->end()
                        ->scalarNode('post_admin')->end()
                        ->scalarNode('blog')->end()
                        ->scalarNode('post')->end()
                    ->end()
                ->end()
            ->end()
        ->end()
        ;

        return $treeBuilder;
    }
}
