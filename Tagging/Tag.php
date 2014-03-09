<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


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

