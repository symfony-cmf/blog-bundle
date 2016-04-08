<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\BlogBundle\Model;

use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishTimePeriodInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishableInterface;

/**
 * Post Model.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class Post implements PublishTimePeriodInterface, PublishableInterface
{
    /**
     * @var Blog
     */
    protected $blog;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $bodyPreview;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var \DateTime
     */
    protected $publishStartDate;

    /**
     * @var \DateTime
     */
    protected $publishEndDate;

    /**
     * @var boolean
     */
    protected $isPublishable = true;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * Get blog.
     *
     * @return Blog
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * Set blog.
     *
     * @param Blog $blog
     *
     * @return Post
     */
    public function setBlog(Blog $blog)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get body preview.
     *
     * @return string
     */
    public function getBodyPreview()
    {
        return $this->bodyPreview;
    }

    /**
     * Set body preview.
     *
     * @param string $bodyPreview
     *
     * @return Post
     */
    public function setBodyPreview($bodyPreview)
    {
        $this->bodyPreview = $bodyPreview;

        return $this;
    }

    /**
     * Get body (the post's content).
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set body (the post's content).
     *
     * @param string $body
     *
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get publication date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set publication date.
     *
     * @param \DateTime $date
     *
     * @return Post
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Is publishable.
     *
     * @return bool
     */
    public function isPublishable()
    {
        return $this->isPublishable;
    }

    /**
     * Set publishable.
     *
     * @param bool $publishable
     *
     * @return Post
     */
    public function setPublishable($publishable)
    {
        $this->isPublishable = $publishable;

        return $this;
    }

    /**
     * Get publish start date.
     *
     * @return \DateTime
     */
    public function getPublishStartDate()
    {
        return $this->publishStartDate;
    }

    /**
     * Set publish start date.
     *
     * @param \DateTime $publishStartDate
     *
     * @return Post
     */
    public function setPublishStartDate(\DateTime $publishStartDate = null)
    {
        $this->publishStartDate = $publishStartDate;

        return $this;
    }

    /**
     * Get publish end date.
     *
     * @return \DateTime
     */
    public function getPublishEndDate()
    {
        return $this->publishEndDate;
    }

    /**
     * Set publish end date.
     *
     * @param \DateTime $publishEndDate
     *
     * @return Post
     */
    public function setPublishEndDate(\DateTime $publishEndDate = null)
    {
        $this->publishEndDate = $publishEndDate;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->title;
    }
}
