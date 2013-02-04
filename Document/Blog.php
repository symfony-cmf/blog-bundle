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
     * Return the routes associated with this blog.
     *
     * @todo: This is wrong, it should return the routeContent
     *        routes that reffer to this blog post.
     */
    public function getRoutes()
    {
        return array(
            new Route('/', array(
                '_controller' => '@SymfonyCmfBlogBundle:Blog:index',
            )),
            new Route('/posts/{slug}', array(
                '_controller' => '@SymfonyCmfBlogBundle:Post:view',
            )),
            // new Route('/tag/{tag}', array(
            //     '_controller' => '@SymfonyCmfBlogBundle:Blog:tag',
            // )),
        );
    }

    public function __toString()
    {
        return $this->name;
    }
}
