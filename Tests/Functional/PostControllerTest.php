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

class PostControllerTest extends BaseTestCase
{
    public function testDetailAction()
    {
        $crawler = $this->request('GET', '/blogs/blog-one/2014-01-01/first-post');

        $this->assertCount(2, $crawler->filter('h1'));
        $this->assertCount(1, $crawler->filter("html:contains('First Post')"),
            'Expected to find the Post\'s title, but it was not.'
        );
    }
}
