<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Component\Routing\RouteAwareInterface;
use Symfony\Component\Routing\Route;

/**
 * Blog Document
 *
 * @author Daniel Leech <daniel@dantleech.com>
 *
 * @PHPCR\Document(referenceable=true)
 */
class Blog implements RouteAwareInterface
{
    /**
     * @PHPCR\Id()
     */
    protected $id;

    /**
     * @PHPCR\NodeName()
     */
    protected $name;

    /**
     * @PHPCR\ParentDocument()
     */
    protected $parent;

    /**
     * @PHPCR\Children()
     */
    protected $posts;

    /**
     * @PHPCR\Referrers(filter="routeContent")
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

    public function __toString()
    {
        return $this->name;
    }
}
