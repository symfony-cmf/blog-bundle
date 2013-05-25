<?php

namespace Symfony\Cmf\Bundle\BlogBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CmfBlogExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('controllers.xml');

        if ($config['use_sonata_admin']) {
            $this->loadSonataAdmin($config, $loader, $container);
        }

        $config['class'] = array_merge(array(
            'blog_admin' => 'Symfony\Cmf\Bundle\BlogBundle\Admin\BlogAdmin',
            'post_admin' => 'Symfony\Cmf\Bundle\BlogBundle\Admin\PostAdmin',
            'blog' => 'Symfony\Cmf\Bundle\BlogBundle\Document\Blog',
            'post' => 'Symfony\Cmf\Bundle\BlogBundle\Document\Post',
        ), isset($config['class']) ? $config['class'] : array());

        foreach ($config['class'] as $type => $classFqn) {
            $container->setParameter(
                $param = sprintf('cmf_blog.%s_class', $type),
                $classFqn
            );
        }
    }

    public function loadSonataAdmin($config, XmlFileLoader $loader, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if ('auto' === $config['use_sonata_admin'] && !isset($bundles['SonataDoctrinePHPCRAdminBundle'])) {
            return;
        }

        $loader->load('blog-admin.xml');
        $container->setParameter($this->getAlias() . '.blog_basepath', $config['blog_basepath']);
    }
}
