<?php

namespace Symfony\Cmf\Bundle\BlogBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SymfonyCmfBlogExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $keys = array(
            'routing_post_controller',
            'routing_post_prefix',
            'routing_tag_controller',
            'routing_tag_prefix',
            'blog_basepath',
            'routing_basepath',
        );

        foreach ($keys as $key) {
            $container->setParameter(
                $this->getAlias().'.'.$key, 
                $config[$key]
            );
        }

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('blog-admin.xml');
        $loader->load('controllers.xml');
        $loader->load('routing.xml');
    }
}
