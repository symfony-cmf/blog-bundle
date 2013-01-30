<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(
 *   repositoryClass="Symfony\Cmf\Bundle\BlogBundle\Repository\PostRepository"
 * )
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
     * @PHPCR\Parent()
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
     * @PHPCR\Boolean
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
    }

    public function getBody()
    {
        return $this->body;
    }
    
    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBodyPreview($length = 255)
    {
        $suffix = strlen($this->body) > $length ? ' ...' : '';

        return substr($this->body, 0, 255).$suffix;
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

    public function getCsvTags()
    {
        $csvTags = '';
        if ($this->tags) {
            $csvTags = implode(',', (array) $this->tags);
        }
        return $csvTags;
    }
    
    public function setCsvTags($tags)
    {
        $tags = explode(',', $tags);
        foreach ($tags as &$tag) {
            $tag = trim($tag);
        }
        $this->tags = $tags;
    }

    public function getTags()
    {
        return $this->tags;
    }
    
    public function setTags($tags)
    {
        $uniq = array();
        foreach ($tags as $tag) {
            $uniq[$tag] = $tag;
        }
        $this->tags = array_values($uniq);
    }
}

