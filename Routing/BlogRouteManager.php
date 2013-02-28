<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Routing;

use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Cmf\Bundle\BlogBundle\Document\Blog;
use Symfony\Cmf\Bundle\RoutingExtraBundle\Document\Route;
use Symfony\Cmf\Bundle\BlogBundle\Util\PostUtils;

/**
 * Class which handles the maintenance of the routes associated with a Blog object.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class BlogRouteManager
{
    const POST_ROUTE_VAR_PATTERN = '/{slug}';
    const TAG_ROUTE_VAR_PATTERN = '/{tag}';

    protected $dm;

    protected $baseRoutePath;
    protected $postPrefix;
    protected $postController;
    protected $tagPrefix;
    protected $tagController;

    /**
     * Constructor
     *
     * @param DocumentManager $dm
     * @param string $postController - of the form: <service_id>:<methodName>
     * @param string $postPrefix - Prefix to use before post slugs, e.g. "posts"
     */
    public function __construct(
        DocumentManager $dm, 
        $baseRoutePath, 
        $postController, 
        $postPrefix,
        $tagController,
        $tagPrefix
    ) 
    {
        $this->dm =$dm;
        $this->baseRoutePath = $baseRoutePath;
        $this->postController = $postController;
        $this->postPrefix = $postPrefix;
        $this->tagController = $tagController;
        $this->tagPrefix = $tagPrefix;
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
     * @return array|null - Blog routes, for testing purposes or NULL if
     *                      blog has no route.
     */
    public function syncRoutes(Blog $blog)
    {
        $ret = array();
        $routes = $blog->getRoutes();

        if (empty($routes)) {
            // create new
            $parentRoute = $this->dm->find(null, $this->baseRoutePath);

            $route = new Route();
            $route->setParent($parentRoute);

            $routes = array($route);
        }

        foreach ($routes as $route) {
            $route->setName(PostUtils::slugify($blog->getName()));
            $route->setRouteContent($blog);
            $route->setDefault('blog_id', $blog->getId());
            $this->dm->persist($route);

            $ret[] = $route;
            $ret = array_merge($ret, $this->syncRoute($route));
        }

        return $ret;
    }

    /**
     * Remove the routes associated with the given blog
     *
     * @param Blog $blog
     */
    public function removeRoutes(Blog $blog)
    {
        $routes = $blog->getRoutes() ? : array();
        
        foreach ($routes as $route) {
            $this->dm->remove($route);
        }
    }

    private function syncRoute(Route $route)
    {
        $ret = array();
        $blogId = $route->getDefault('blog_id');

        $routeConfigs = array(
            'Symfony\Cmf\Bundle\BlogBundle\Document\PostRoute' => array(
                'prefix' => $this->postPrefix,
                'controller' => $this->postController,
                'variable_pattern' => self::POST_ROUTE_VAR_PATTERN,
            ),
            'Symfony\Cmf\Bundle\BlogBundle\Document\TagRoute' => array(
                'prefix' => $this->tagPrefix,
                'controller' => $this->tagController,
                'variable_pattern' => self::TAG_ROUTE_VAR_PATTERN,
            ),
        );

        foreach ($routeConfigs as $routeClass => $routeConfig) {
            $subRoute = null;
            $routeChildren = $route->getRouteChildren() ? : array();

            foreach ($routeChildren as $child) {
                if ($child instanceof $routeClass) {
                    $subRoute = $child;
                    break;
                }
            }

            if (null === $subRoute) {
                $subRoute = new $routeClass;
                $subRoute->setParent($route);
            }

            $subRoute->setName($routeConfig['prefix']);
            $subRoute->setDefault('_controller', $routeConfig['controller']);
            $subRoute->setVariablePattern($routeConfig['variable_pattern']);
            $subRoute->setDefault('blog_id', $blogId);
            $subRoute->setDefault('_locale', $route->getDefault('_locale'));

            $this->dm->persist($subRoute);
            $ret[] = $subRoute;
        }

        return $ret;
    }
}
