<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Cmf\Component\Testing\Functional\BaseTestCase as CmfBaseTestCase;

class BaseTestCase extends CmfBaseTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Application
     */
    protected $application;

    /**
     * @var RouterInterface
     */
    protected $router;

    public function setUp()
    {
        $this->client = $this->createClient($this->getKernelConfiguration());

        $this->application = new Application($this->client->getKernel());
        $this->application->setAutoExit(false);

        $this->router = $this->get('router');

//        $this->db('PHPCR')->loadFixtures(array(
//            'Symfony\Cmf\Bundle\BlogBundle\Tests\Resources\DataFixtures\PHPCR\LoadBlogData',
//        ));

        $this->runConsole('doctrine:phpcr:fixtures:load', array(
            '--fixtures' => __DIR__.'/../Resources/DataFixtures/PHPCR',
            '--no-interaction' => true,
        ));
    }

    /**
     * @param string $serviceId
     * @return object
     */
    protected function get($serviceId)
    {
        return $this->client->getContainer()->get($serviceId);
    }

    /**
     * @param string $parameter
     * @return mixed
     */
    protected function getParameter($parameter)
    {
        return $this->client->getContainer()->getParameter($parameter);
    }

    /**
     * @param string $method
     * @param string $url
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function request($method, $url)
    {
        return $this->client->request($method, $url);
    }

    /**
     * @param string $method
     * @param string $route
     * @param array $parameters
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function requestRoute($method, $route, array $parameters = array())
    {
        return $this->request(
            $method,
            $this->router->generate($route, $parameters)
        );
    }

    /**
     * Returns the unique ID Sonata Admins use to prefix form fields
     *
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     * @param string $filter
     * @return string
     */
    protected function getAdminFormNamePrefix(\Symfony\Component\DomCrawler\Crawler $crawler, $filter = 'input[type=text]')
    {
        $parts = explode('_', $crawler->filter($filter)->first()->attr('id'));

        return $parts[0];
    }

    /**
     * @param string $command
     * @param array $options
     * @return int
     */
    protected function runConsole($command, array $options = array())
    {
        $options['-e'] = 'test'; // test environment
        $options['-q'] = null;   // suppress the command's output
        $options['command'] = $command;

        return $this->application->run(new ArrayInput($options));
    }
}
