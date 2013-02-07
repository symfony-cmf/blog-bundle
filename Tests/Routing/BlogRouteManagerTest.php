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
            '/cms/routes',
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
        $this->blog->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('This is a test blog'));
        $this->dm->expects($this->once())
            ->method('find')
            ->with(null, '/cms/routes');
        $this->dm->expects($this->exactly(2))
            ->method('persist');

        $res = $this->brm->syncRoutes($this->blog);
        $this->assertCount(2, $res);
        $route = $res[0];
        $this->assertEquals('this-is-a-test-blog', $route->getName());
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

        $res = $this->brm->syncRoutes($this->blog);
        $this->assertCount(2, $res);
        $route = $res[1];
        $this->assertEquals('test_controller', $route->getDefault('_controller'));
        $this->assertEquals('test', $route->getName());
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

        $this->brm->removeRoutes($this->blog);
    }
}
