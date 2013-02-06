<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Routing;

use Symfony\Cmf\Bundle\BlogBundle\Routing\BlogRouteManager;

class BlogRouteManagerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->dm = $this->getMockBuilder('Doctrine\ODM\PHPCR\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->brm = new BlogRouteManager(
            $this->dm,
            'test_controller',
            'test'
        );
        $this->blog = $this->getMock('Symfony\Cmf\Bundle\BlogBundle\Document\Blog');
        $this->route1 = $this->getMock('Symfony\Cmf\Bundle\RoutingExtraBundle\Document\Route');
    }

    public function testSyncWithNoRoutes()
    {
        $this->blog->expects($this->once())
            ->method('getRoutes')
            ->will($this->returnValue(array()));

        $res = $this->brm->syncSubRoutes($this->blog);
        $this->assertNull($res);
    }

    public function testSyncWithOneRoute()
    {
        $this->blog->expects($this->once())
            ->method('getRoutes')
            ->will($this->returnValue(array(
                $this->route1
            )));
        $this->dm->expects($this->once())
            ->method('persist');

        $res = $this->brm->syncSubRoutes($this->blog);
        $this->assertCount(1, $res);
        $this->assertEquals('test_controller', $res[0]->getDefault('_controller'));
        $this->assertEquals('test', $res[0]->getName());
    }

    public function testRemove()
    {
        $this->blog->expects($this->once())
            ->method('getRoutes')
            ->will($this->returnValue(array(
                $this->route1
            )));
        $this->dm->expects($this->once())
            ->method('remove')
            ->with($this->route1);

        $this->brm->removeSubRoutes($this->blog);
    }
}
