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
        $treeBuilder->root('cmf_blog')
            ->children()
                ->enumNode('use_sonata_admin')
                    ->values(array(true, false, 'auto'))
                    ->defaultValue('auto')
                ->end()

                ->arrayNode('integrate_menu')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->enumNode('enabled')
                            ->values(array(true, false, 'auto'))
                            ->defaultValue('auto')
                        ->end()
                        ->scalarNode('content_key')->defaultNull()->end()
                    ->end()
                ->end()
                ->scalarNode('blog_basepath')
                    ->isRequired()
                ->end()
                ->scalarNode('routing_post_controller')
                    ->defaultValue('cmf_blog.blog_controller:viewPostAction')
                ->end()
                ->scalarNode('routing_post_prefix')
                    ->defaultValue('posts')
                ->end()
                ->scalarNode('routing_tag_controller')
                    ->defaultValue('cmf_blog.blog_controller:listAction')
                ->end()
                ->scalarNode('routing_tag_prefix')
                    ->defaultValue('tag')
                ->end()
                ->arrayNode('class')
                    ->children()
                        # defaults defined in CmfBlogExtension
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
