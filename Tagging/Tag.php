<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tagging;

use Symfony\Cmf\Component\Routing\RouteAwareInterface;
use Symfony\Cmf\Bundle\BlogBundle\Document\Blog;

/**
 * Class representation of a tag that implements
 * routing aware.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class Tag implements RouteAwareInterface
{
    protected $name;
    protected $blog;

    public function __construct(Blog $blog, $name)
    {
        $this->name = $name;
        $this->blog = $blog;
    }

    public function getRoutes()
    {
        return $this->blog->getTagRoutes();
    }

    public function __toString()
    {
        return $this->name;
    }
}
