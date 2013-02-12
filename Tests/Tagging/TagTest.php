<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Tagging;

use Symfony\Cmf\Bundle\BlogBundle\Tagging\Tag;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $blog = $this->getMock('Symfony\Cmf\Bundle\BlogBundle\Document\Blog');
        $this->tag = new Tag($blog, 'foo');
    }

    public function testTag()
    {
        $this->assertEquals('foo', (string) $this->tag);
    }
}
