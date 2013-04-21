<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Functional;

require __DIR__.'/app/AppKernel.php';

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseTestCase extends WebTestCase
{
    static protected function createKernel(array $options = array())
    {
        return new AppKernel(
            isset($options['config']) ? $options['config'] : 'default.yml'
        );
    }

    public function getContainer()
    {
        return self::$kernel->getContainer();
    }

    public function getDm()
    {
        return $this->getContainer()->get('doctrine_phpcr.odm.document_manager');
    }

    public function setUp(array $options = array(), $routebase = null)
    {
        self::$kernel = self::createKernel($options);
        self::$kernel->init();
        self::$kernel->boot();

        $session = $this->getContainer()->get('doctrine_phpcr.session');

        if ($session->nodeExists('/test')) {
            $session->getNode('/test')->remove();
        }

        if (!$session->nodeExists('/test')) {
            $session->getRootNode()->addNode('test', 'nt:unstructured');
        }

        $session->save();
    }
}

