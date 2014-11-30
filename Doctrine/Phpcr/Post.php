<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Bundle\BlogBundle\Doctrine\Phpcr;

use Symfony\Cmf\Bundle\BlogBundle\Util\PostUtils;
use Symfony\Cmf\Bundle\BlogBundle\Model\Post as PostModel;
use Symfony\Cmf\Bundle\BlogBundle\Model\Blog as BlogModel;
use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;

/**
 * Object representing a blog post.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class Post extends PostModel implements RouteReferrersReadInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $slug;

    /**
     * List of referring routes
     *
     * @var \Symfony\Component\Routing\Route[]
     */
    protected $routes;

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * {@inheritDoc}
     */
    public function setTitle($title)
    {
        parent::setTitle($title);

        $this->slug = PostUtils::slugify($title);

        return $this;
    }

    /**
     * Get parent document
     *
     * @return BlogModel
     */
    public function getParentDocument()
    {
        return $this->blog;
    }

    /**
     * Set parent document
     *
     * @param BlogModel $blog
     * @return Post
     */
    public function setParentDocument(BlogModel $blog)
    {
        parent::setBlog($blog);

        return $this;
    }

    /**
     * Get routes
     *
     * @return \Symfony\Component\Routing\Route[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}
