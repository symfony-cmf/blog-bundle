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

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Cmf\Bundle\RoutingBundle\Routing\DynamicRouter;

/**
 * This is the class that loads and manages your bundle configuration.
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
        $loader->load('services.xml');

        if (isset($config['persistence']['phpcr'])) {
            $this->loadPhpcrPersistence($config['persistence']['phpcr'], $loader, $container);
        }

        if ($config['sonata_admin']['enabled']) {
            $this->loadSonataAdmin($config['sonata_admin'], $loader, $container);
        }

        if ($config['menu']['enabled']) {
            $this->loadMenu($config['menu'], $loader, $container);
        }

        if (!$this->handlePagination($config['pagination'], $loader, $container)) {
            // this parameter is used in the cmf_blog.blog_controller service definition, so
            // it must be defined until it's a viable option to use the expression language instead
            $container->setParameter($this->getAlias().'.pagination.posts_per_page', 0);
        }
    }

    private function loadPhpcrPersistence($config, XmlFileLoader $loader, ContainerBuilder $container)
    {
        $container->setParameter($this->getAlias().'.blog_basepath', $config['blog_basepath']);

        foreach ($config['class'] as $type => $classFqn) {
            $container->setParameter(
                $param = sprintf('cmf_blog.phpcr.%s.class', $type),
                $classFqn
            );
        }

        $loader->load('initializer-phpcr.xml');
        $loader->load('doctrine-phpcr.xml');
    }

    private function loadSonataAdmin(array $config, XmlFileLoader $loader, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (!isset($bundles['SonataDoctrinePHPCRAdminBundle'])) {
            if ('auto' === $config['enabled']) {
                return;
            }

            throw new InvalidConfigurationException('Explicitly enabled sonata admin integration but SonataDoctrinePHPCRAdminBundle is not loaded');
        }

        $loader->load('admin.xml');
    }

    private function loadMenu(array $config, XmlFileLoader $loader, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (!isset($bundles['CmfMenuBundle'])) {
            if ('auto' === $config['enabled']) {
                return;
            }

            throw new InvalidConfigurationException('Explicitly enabled menu integration but CmfMenuBundle is not loaded');
        }

        if (empty($config['content_key'])) {
            if (!class_exists('Symfony\\Cmf\\Bundle\\RoutingBundle\\Routing\\DynamicRouter')) {
                if ('auto' === $config['enabled']) {
                    return;
                }

                throw new InvalidConfigurationException('You need to set the content_key when not using the CmfRoutingBundle DynamicRouter');
            }
            $contentKey = DynamicRouter::CONTENT_KEY;
        } else {
            $contentKey = $config['content_key'];
        }

        $container->setParameter($this->getAlias().'.content_key', $contentKey);

        $loader->load('menu.xml');
    }

    private function handlePagination(array $config, XmlFileLoader $loader, ContainerBuilder $container)
    {
        if (!$config['enabled']) {
            return false;
        }
        
        $bundles = $container->getParameter('kernel.bundles');
        if (!isset($bundles['KnpPaginatorBundle'])) {
            if ('auto' === $config['enabled']) {
                return false;
            }

            throw new InvalidConfigurationException('Explicitly enabled pagination but KnpPaginatorBundle is not loaded');
        }
        $container->setParameter($this->getAlias().'.pagination.posts_per_page', $config['posts_per_page']);

        return true;
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
        return 'http://cmf.symfony.com/schema/dic/cmf_blog';
    }
}
