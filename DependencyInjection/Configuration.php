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
                ->scalarNode('default_template')->defaultValue('SymfonyCmfBlogBundle::symfony_cmf_blog_layout.html.twig')->end()
                ->scalarNode('blog_basepath')->defaultValue('/cms/content')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
