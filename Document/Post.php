<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;

use Symfony\Cmf\Bundle\BlogBundle\Util\PostUtils;

use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishTimePeriodInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishableInterface;

/**
 * Object representing a blog post.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class Post implements RouteReferrersReadInterface, PublishTimePeriodInterface, PublishableInterface
{
    /**
     * ID / Path to to this object
     * @var string
     */
    protected $id;

    /**
     * Node name (same as slug)
     * @var string
     */
    protected $name;

    /**
     * READ ONLY: Post slug (cannot query directly on name field)
     */
    protected $slug;

    /**
     * Blog - this is the parent document.
     * @var Blog
     */
    protected $blog;

    /**
     * Post title (name is generated from this)
     * @var string
     */
    protected $title;

    /**
     * Post body text
     * @var string
     */
    protected $body;

    /**
     * Date of publication
     * @var \DateTime
     */
    protected $date;

    /**
     * List of referring routes
     */
    protected $routes;

    /**
     * Date to start publishing from
     * @var \DateTime
     */
    protected $publishStartDate;

    /**
     * Date to stop publishing from
     * @var \DateTime
     */
    protected $publishEndDate;

    /**
     * If the document should be publishable
     * @var Boolean
     */
    protected $isPublishable = true;

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
        $this->slug = $this->name;
    }

    public function getSlug()
    {
        return $this->slug;
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

    public function getParent()
    {
        return $this->getBlog();
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

    public function getBodyPreview($length = 255)
    {
        $suffix = strlen($this->body) > $length ? ' ...' : '';

        return substr($this->body, 0, 255).$suffix;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function isPublishable()
    {
        return $this->isPublishable;
    }

    public function setPublishable($publishable)
    {
        $this->isPublishable = $publishable;
    }

    public function getPublishStartDate()
    {
        return $this->publishStartDate;
    }

    public function setPublishStartDate(\DateTime $publishStartDate = null)
    {
        $this->publishStartDate = $publishStartDate;
    }

    public function getPublishEndDate()
    {
        return $this->publishEndDate;
    }

    public function setPublishEndDate(\DateTime $publishEndDate = null)
    {
        $this->publishEndDate = $publishEndDate;
    }

    public function __toString()
    {
        return (string) $this->name;
    }
}
