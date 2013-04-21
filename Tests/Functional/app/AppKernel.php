<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Functional;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    private $config;

    public function __construct($config)
    {
        parent::__construct('test', true);

        $fs = new Filesystem();

        if (!$fs->isAbsolutePath($config)) {
            $config = __DIR__.'/config/'.$config;
        }

        if (!file_exists($config)) {
            throw new \RuntimeException(sprintf('The config file "%s" does not exist.', $config));
        }

        $this->config = $config;
    }

    public function registerBundles()
    {
        return array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\MonologBundle\MonologBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Doctrine\Bundle\PHPCRBundle\DoctrinePHPCRBundle(),
            new \Symfony\Cmf\Bundle\RoutingExtraBundle\SymfonyCmfRoutingExtraBundle(),
            new \Symfony\Cmf\Bundle\BlogBundle\SymfonyCmfBlogBundle(),

            new \Sonata\jQueryBundle\SonatajQueryBundle(),
            new \Sonata\BlockBundle\SonataBlockBundle(),
            new \Sonata\AdminBundle\SonataAdminBundle(),
            new \Sonata\DoctrinePHPCRAdminBundle\SonataDoctrinePHPCRAdminBundle(),
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->config);
    }

    public function getCacheDir()
    {
        return __DIR__.'/cache';
    }
}
