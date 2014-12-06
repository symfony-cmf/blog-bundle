<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Bundle\BlogBundle\Doctrine\Phpcr;

use Symfony\Cmf\Bundle\BlogBundle\Model\Blog as BlogModel;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;

/**
 * Blog Document
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class Blog extends BlogModel implements RouteReferrersReadInterface, RouteObjectInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * Parent Document
     */
    protected $parent;

    /**
     * Routes (mapped from Route::content)
     *
     * @var \Symfony\Component\Routing\Route[]
     */
    protected $routes;


    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get parent document
     */
    public function getParentDocument()
    {
        return $this->parent;
    }

    /**
     * Set parent document
     *
     * @param $parent
     * @return Blog
     */
    public function setParentDocument($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return \Symfony\Component\Routing\Route[] Route instances that point to this content
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    // FIXME: these getRoutes functions should probably go into a repository so classes aren't hard coded

    public function getPostsRoutes()
    {
        return $this->getSubRoutes('Symfony\Cmf\Bundle\BlogBundle\Doctrine\Phpcr\PostRoute');
    }

    public function getTagRoutes()
    {
        return $this->getSubRoutes('Symfony\Cmf\Bundle\BlogBundle\Doctrine\Phpcr\TagRoute');
    }

    public function getSubRoutes($routeClass)
    {
        $subRoutes = array();

        foreach ($this->routes as $route) {
            foreach ($route->getRouteChildren() as $routeChild)
                if ($routeChild instanceof $routeClass) {
                    $subRoutes[] = $routeChild;
                }
        }

        if (empty($subRoutes)) {
            throw new \Exception(sprintf(
                'Could not find route of class "%s", this special route should be a child '.
                'of the blogs route.',
                $routeClass
            ));
        }

        return $subRoutes;
    }

    public function getContent()
    {
        return $this;
    }

    public function getRouteKey()
    {
        return null;
    }
}
