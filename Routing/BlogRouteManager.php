<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Routing;

use Symfony\Cmf\Bundle\BlogBundle\Document\PostRoute;
use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Cmf\Bundle\BlogBundle\Document\Blog;
use Symfony\Cmf\Bundle\RoutingExtraBundle\Document\Route;

/**
 * Class which handles the maintainance of the routes associated
 * with a Blog object.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class BlogRouteManager
{
    const POST_ROUTE_VAR_PATTERN = '/{slug}';

    protected $dm;

    protected $postPrefix;
    protected $postController;

    /**
     * Constructor
     *
     * @param DocumentManager $dm
     * @param string $postController - of the form: <service_id>:<methodName>
     * @param string $postPrefix - Prefix to use before post slugs, e.g. "posts"
     */
    public function __construct(DocumentManager $dm, $postController, $postPrefix) 
    {
        $this->dm =$dm;
        $this->postController = $postController;
        $this->postPrefix = $postPrefix;
    }

    /**
     * Finds the route for the given Blog entity and
     * ensures that it has the required children.
     *
     *   - Creates routes if not existing
     *   - Updates routes to current defaults
     *
     * If no route is associated with the blog, we 
     * do nothing.
     *
     * @param Blog $blog
     * 
     * @return array|null - Child routes, for testing purposes or NULL if
     *                      blog has no route.
     */
    public function syncSubRoutes(Blog $blog)
    {
        $routes = $blog->getRoutes();

        if (empty($routes)) {
            return null;
        }

        $ret = array();

        foreach ($routes as $route) {
            $ret[] = $this->syncRoute($route);
        }

        return $ret;
    }

    /**
     * Remove the routes associated with the given blog
     *
     * @param Blog $blog
     */
    public function removeSubRoutes(Blog $blog)
    {
        $routes = $blog->getRoutes() ? : array();
        
        foreach ($routes as $route) {
            $this->dm->remove($route);
        }
    }

    private function syncRoute(Route $route)
    {
        $postRoute = null;
        $routeChildren = $route->getChildren() ? : array();

        foreach ($routeChildren as $child) {
            if ($child instanceof PostRoute) {
                $postRoute = $child;
                break;
            }
        }

        if (null === $postRoute) {
            $postRoute = new PostRoute;
            $postRoute->setParent($route);
        }

        $postRoute->setName($this->postPrefix);
        $postRoute->setDefault('_controller', $this->postController);
        $postRoute->setVariablePattern(self::POST_ROUTE_VAR_PATTERN);

        $this->dm->persist($postRoute);

        return $postRoute;
    }
}
