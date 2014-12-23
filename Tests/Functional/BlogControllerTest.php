<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Functional;

class BlogControllerTest extends BaseTestCase
{
    public function testListAction()
    {
        $crawler = $this->request('GET', '/blogs');

        $this->assertCount(3, $crawler->filter('h2'));
    }

    /**
     * Pagination disabled
     */
    public function testDetailAction()
    {
        $crawler = $this->request('GET', '/blogs/blog-three');

        $this->assertCount(1, $crawler->filter('h1'));
        $this->assertCount(1, $crawler->filter('h2'));
        $this->assertCount(12, $crawler->filter('h3'));
    }
}
