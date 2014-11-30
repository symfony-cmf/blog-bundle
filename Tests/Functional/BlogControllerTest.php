<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Functional;

class BlogControllerTest extends BaseTestCase
{
    public function testListAction()
    {
        $crawler = $this->request('GET', '/blogs');

        $this->assertCount(3, $crawler->filter('h2'));
    }
}
