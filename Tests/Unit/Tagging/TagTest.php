<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Unit\Tagging;

use Symfony\Cmf\Bundle\BlogBundle\Tagging\Tag;

class TagTest extends \PHPUnit_Framework_TestCase
{
    private $tag;

    public function setUp()
    {
        $blog = $this->getMock('Symfony\Cmf\Bundle\BlogBundle\Doctrine\Phpcr\Blog');
        $this->tag = new Tag($blog, 'foo');
    }

    public function testTag()
    {
        $this->assertEquals('foo', (string) $this->tag);
    }
}
