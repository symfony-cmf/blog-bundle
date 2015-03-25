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

class BlogControllerTest extends BaseTestCase
{
    public function testListAction()
    {
        $crawler = $this->request('GET', '/blogs');

        $this->assertCount(3, $crawler->filter('h2'));
    }

    /**
     * Pagination disabled.
     */
    public function testDetailAction()
    {
        $crawler = $this->request('GET', '/blogs/blog-three');

        $this->assertCount(1, $crawler->filter('h2'));
        $this->assertCount(12, $crawler->filter('h3'));
    }
}
