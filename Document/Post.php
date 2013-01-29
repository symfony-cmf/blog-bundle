<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Bundle\CoreBundle\Document\Endpoint;

/**
 * @PHPCR\Document(
 *   referenceable=true,
 *   repositoryClass="Symfony\Cmf\Bundle\BlogBundle\Repository\PostRepository"
 * )
 */
class Post extends Endpoint
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
    protected $parent;

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
     * @PHPCR\ReferenceOne(
     *   targetDocument="Symfony\Cmf\Bundle\BlogBundle\Document\Blog",
     *   strategy="hard"
     * )
     */
    public $blog;

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
    
    public function getParent() 
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
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

    public function getParent()
    {
        return $this->parent;
    }
    
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getUuid()
    {
        return $this->uuid;
    }
    
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function getBlog()
    {
        return $this->blog;
    }
    
    public function setBlog($blog)
    {
        $this->blog = $blog;
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

