<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Routing\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ODM\PHPCR\Event;
use Symfony\Cmf\Bundle\BlogBundle\Document\Blog;
use Doctrine\ODM\PHPCR\Event\LifecycleEventArgs;
use Symfony\Cmf\Bundle\BlogBundle\Routing\BlogRouteManager;

/**
 * Doctrine PHPCR event subscriber which listends
 * for persistance operations of Blog objects and updates
 * the children objects corresponding route.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class BlogSubscriber implements EventSubscriber
{
    protected $brm;

    public function __construct(BlogRouteManager $brm)
    {
        $this->brm = $brm;
    }

    public function getSubscribedEvents()
    {
        return array(
            Event::preUpdate,
            Event::prePersist,
            Event::preRemove,
        );
    }

    /**
     * Update and persist the sub routes of the Blogs route
     * before flush.
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->update($args);
    }

    /**
     * Create and persist the sub routes of the Blogs route
     * before flush.
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->update($args);
    }

    /**
     * Remove the blogs sub routes before flush
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $doc = $args->getDocument();

        if ($doc instanceof Blog) {
            $this->brm->removeSubRoutes($doc);
        }
    }

    protected function update(LifecycleEventArgs $args)
    {
        $doc = $args->getDocument();

        if ($doc instanceof Blog) {
            $this->brm->syncSubRoutes($doc);
        }
    }
}
