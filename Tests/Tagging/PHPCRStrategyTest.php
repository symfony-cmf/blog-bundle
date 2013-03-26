<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Tagging;

use Symfony\Cmf\Bundle\BlogBundle\Tagging\PHPCRStrategy;

class PHPCRStrategyTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->blogRepo = $this->getMockBuilder('Symfony\Cmf\Bundle\BlogBundle\Repository\BlogRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $this->postRepo = $this->getMockBuilder('Symfony\Cmf\Bundle\BlogBundle\Repository\PostRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $this->blog = $this->getMock('Symfony\Cmf\Bundle\BlogBundle\Document\Blog');

        $this->strategy = new PHPCRStrategy($this->blogRepo, $this->postRepo);
    }

    public function testTag()
    {
        $this->postRepo->expects($this->once())
            ->method('getTagsForBlog')
            ->will($this->returnValue(array(
                'foo', 'foo', 'foo', 'bar', 'bar', 'boo'
            )));
        $this->blogRepo->expects($this->once())
            ->method('find')
            ->with('/path/to/blog')
            ->will($this->returnValue($this->blog));

        $weightedTags = $this->strategy->getWeightedTags('/path/to/blog');
        $this->assertCount(3, $weightedTags);
        $this->assertEquals(3, $weightedTags['foo']['count']);
        $this->assertEquals(1, $weightedTags['foo']['weight']);
        $this->assertEquals(0.67, $weightedTags['bar']['weight']);
        $this->assertEquals(2, $weightedTags['bar']['count']);
        $this->assertEquals(0.33, $weightedTags['boo']['weight']);
        $this->assertEquals(1, $weightedTags['boo']['count']);
    }
}
