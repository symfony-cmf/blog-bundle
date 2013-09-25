<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;
use Symfony\Component\Routing\Route;

/**
 * Blog Document
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class Blog implements RouteReferrersReadInterface
{
    /**
     * Identifier
     */
    protected $id;

    /**
     * Node Name / Blog Title
     */
    protected $name;

    /**
     * Parent Document
     */
    protected $parent;

    /**
     * Posts (mapped as children)
     */
    protected $posts;

    /**
     * Routes (mapped from Route::content)
     */
    protected $routes;


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getPosts()
    {
        return $this->posts;
    }

    public function setPosts($posts)
    {
        $this->posts = array();
        foreach ($posts as $post) {
            $this->addPost($post);
        }
    }

    public function addPost(Post $post)
    {
        $this->posts[] = $post;
    }

    /**
     * @return \Symfony\Component\Routing\Route[] Route instances that point to this content
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    public function getPostsRoutes()
    {
        return $this->getSubRoutes('Symfony\Cmf\Bundle\BlogBundle\Document\PostRoute');
    }

    public function getTagRoutes()
    {
        return $this->getSubRoutes('Symfony\Cmf\Bundle\BlogBundle\Document\TagRoute');
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

    public function __toString()
    {
        return (string) $this->name;
    }
}
