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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

use Symfony\Cmf\Bundle\RoutingBundle\Routing\DynamicRouter;

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
        if ($config['integrate_menu']['enabled']) {
            $this->loadMenuIntegration($config, $loader, $container);
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

    private function loadSonataAdmin($config, XmlFileLoader $loader, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if ('auto' === $config['use_sonata_admin'] && !isset($bundles['SonataDoctrinePHPCRAdminBundle'])) {
            return;
        }

        $loader->load('blog-admin.xml');
        $container->setParameter($this->getAlias() . '.blog_basepath', $config['blog_basepath']);
    }

    private function loadMenuIntegration($config, XmlFileLoader $loader, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if ('auto' === $config['integrate_menu']['enabled'] && !isset($bundles['CmfMenuBundle'])) {
            return;
        }

        if (empty($config['integrate_menu']['content_key'])) {
            if (!class_exists('Symfony\\Cmf\\Bundle\\RoutingBundle\\Routing\\DynamicRouter')) {
                if ('auto' === $config['integrate_menu']) {
                    return;
                }
                throw new \RuntimeException('You need to set the content_key when not using the CmfRoutingBundle DynamicRouter');
            }
            $contentKey = DynamicRouter::CONTENT_KEY;
        } else {
            $contentKey = $config['integrate_menu']['content_key'];
        }

        $container->setParameter('cmf_blog.content_key', $contentKey);

        $loader->load('menu.xml');
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    public function getNamespace()
    {
        return 'http://cmf.symfony.com/schema/dic/blog';
    }
}
