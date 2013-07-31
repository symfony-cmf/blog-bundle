<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tagging;

use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;
use Symfony\Cmf\Bundle\BlogBundle\Document\Blog;

class Tag implements RouteReferrersReadInterface
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
        return array();
    }

    public function __toString()
    {
        return (string)$this->name;
    }
}

