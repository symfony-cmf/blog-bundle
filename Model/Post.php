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

use Symfony\Cmf\Bundle\BlogBundle\Util\PostUtils;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishTimePeriodInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishableInterface;

/**
 * Post Model
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
    protected $content;

    /**
     * @var \DateTime
     */
    protected $publicationDate;

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
     * Constructor
     */
    public function __construct()
    {
        $this->publicationDate = new \DateTime();
    }

    /**
     * Get blog
     *
     * @return Blog
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * Set blog
     *
     * @param Blog $blog
     * @return Post
     */
    public function setBlog(Blog $blog)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the post's content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the post's content
     *
     * @param string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get publication date
     *
     * @return \DateTime
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * Set publication date
     *
     * @param \DateTime $publicationDate
     * @return Post
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * Is publishable
     *
     * @return bool
     */
    public function isPublishable()
    {
        return $this->isPublishable;
    }

    /**
     * Set publishable
     *
     * @param bool $publishable
     * @return Post
     */
    public function setPublishable($publishable)
    {
        $this->isPublishable = $publishable;

        return $this;
    }

    /**
     * Get publish start date
     *
     * @return \DateTime
     */
    public function getPublishStartDate()
    {
        return $this->publishStartDate;
    }

    /**
     * Set publish start date
     *
     * @param \DateTime $publishStartDate
     * @return Post
     */
    public function setPublishStartDate(\DateTime $publishStartDate = null)
    {
        $this->publishStartDate = $publishStartDate;

        return $this;
    }

    /**
     * Get publish end date
     *
     * @return \DateTime
     */
    public function getPublishEndDate()
    {
        return $this->publishEndDate;
    }

    /**
     * Set publish end date
     *
     * @param \DateTime $publishEndDate
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
