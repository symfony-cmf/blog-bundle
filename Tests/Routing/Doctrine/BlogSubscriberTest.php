<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Routing\Doctrine;

use Symfony\Cmf\Bundle\BlogBundle\Routing\Doctrine\BlogSubscriber;

class BlogSubscriberTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->brm = $this->getMockBuilder(
            'Symfony\Cmf\Bundle\BlogBundle\Routing\BlogRouteManager'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->lifecycleEventArgs = $this->getMockBuilder(
            'Doctrine\ODM\PHPCR\Event\LifecycleEventArgs'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->blog = $this->getMock('Symfony\Cmf\Bundle\BlogBundle\Document\Blog');

        $this->subscriber = new BlogSubscriber($this->brm);
    }

    public function dataProviderUpdateWithBlog()
    {
        return array(
            array('prePersist'),
            array('preUpdate')
        );
    }

    /**
     * @dataProvider dataProviderUpdateWithBlog
     */
    public function testUpdateWithBlog($method)
    {
        $this->lifecycleEventArgs->expects($this->once())
            ->method('getDocument')
            ->will($this->returnValue($this->blog));
        $this->brm->expects($this->once())
            ->method('syncSubRoutes')
            ->with($this->blog);

        $this->subscriber->$method($this->lifecycleEventArgs);
    }

    public function testUpdateNotBlog()
    {
        $this->lifecycleEventArgs->expects($this->once())
            ->method('getDocument')
            ->will($this->returnValue(new \stdClass));
        $this->brm->expects($this->never())
            ->method('syncSubRoutes');

        $this->subscriber->preUpdate($this->lifecycleEventArgs);
    }

    public function testRemoveWithBlog()
    {
        $this->lifecycleEventArgs->expects($this->once())
            ->method('getDocument')
            ->will($this->returnValue($this->blog));
        $this->brm->expects($this->once())
            ->method('removeSubRoutes');

        $this->subscriber->preRemove($this->lifecycleEventArgs);
    }

    public function testRemoveNotBlog()
    {
        $this->lifecycleEventArgs->expects($this->once())
            ->method('getDocument')
            ->will($this->returnValue(new \stdClass));
        $this->brm->expects($this->never())
            ->method('removeSubRoutes');

        $this->subscriber->preRemove($this->lifecycleEventArgs);
    }
}
