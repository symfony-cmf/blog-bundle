<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


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

                // admin
                ->arrayNode('sonata_admin')
                    ->canBeEnabled()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
                    ->end()
                ->end()

                // menu
                ->arrayNode('integrate_menu')
                    ->addDefaultsIfNotSet()
                    ->canBeEnabled()
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
                        ->scalarNode('content_key')->defaultNull()->end()
                    ->end()
                ->end()

                // pagination
                ->arrayNode('pagination')
                    ->addDefaultsIfNotSet()
                    ->canBeEnabled()
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
                        ->scalarNode('posts_per_page')->defaultValue(5)->end()
                    ->end()
                ->end()

                // persistence
                ->arrayNode('persistence')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('phpcr')
                            ->addDefaultsIfNotSet()
                            ->canBeEnabled()
                            ->children()
                                ->scalarNode('blog_basepath')
                                    ->defaultValue('/cms/blogs')->cannotBeEmpty()
                                ->end()
                                ->arrayNode('class')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('blog_admin')
                                            ->defaultValue('Symfony\Cmf\Bundle\BlogBundle\Admin\BlogAdmin')
                                        ->end()
                                        ->scalarNode('post_admin')
                                            ->defaultValue('Symfony\Cmf\Bundle\BlogBundle\Admin\PostAdmin')
                                        ->end()
                                        ->scalarNode('blog')
                                            ->defaultValue('Symfony\Cmf\Bundle\BlogBundle\Doctrine\Phpcr\Blog')
                                        ->end()
                                        ->scalarNode('post')
                                            ->defaultValue('Symfony\Cmf\Bundle\BlogBundle\Doctrine\Phpcr\Post')
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

            ->end()
        ->end()
        ;

        return $treeBuilder;
    }
}
