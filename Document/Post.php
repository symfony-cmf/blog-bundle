<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Bundle\BlogBundle\Util\PostUtils;

/**
 * @PHPCR\Document()
 */
class Post
{
    /**
     * @PHPCR\Id
     */
    protected $id;

    /**
     * @PHPCR\NodeName()
     */
    protected $name;

    /**
     * @PHPCR\ParentDocument()
     */
    protected $blog;

    /**
     * @PHPCR\String()
     */
    protected $title;

    /**
     * @PHPCR\String()
     */
    protected $body;

    /**
     * @PHPCR\Date()
     */
    protected $date;

    /**
     * @PHPCR\String()
     */
    protected $status;

    /**
     * @PHPCR\String(multivalue=true)
     */
    protected $tags = array();

    public function __construct()
    {
        $this->date = new \DateTime();
    }

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
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
        $this->name = PostUtils::slugify($title);
    }

    public function getBody()
    {
        return $this->body;
    }
    
    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getDate()
    {
        return $this->date;
    }
    
    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getBlog()
    {
        return $this->blog;
    }
    
    public function setBlog(Blog $blog)
    {
        $this->blog = $blog;

        // The user can create a post from Admin, so
        // we let them choose and automatically make
        // this Post a child of selected blog.
        $this->parent = $blog;
    }

    public function getStatus()
    {
        return $this->status;
    }
    
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getTags()
    {
        return $this->tags;
    }
    
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function __toString()
    {
        return $this->title;
    }
}

