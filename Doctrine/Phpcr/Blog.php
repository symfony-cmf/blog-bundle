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

use Symfony\Cmf\Bundle\BlogBundle\Model\Blog as BlogModel;
use Symfony\Cmf\Bundle\BlogBundle\Util\PostUtils;
use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;
use Doctrine\ODM\PHPCR\Document\Generic;

/**
 * Blog Document.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class Blog extends BlogModel implements RouteReferrersReadInterface
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
     * Parent Document.
     *
     * @var Generic
     */
    protected $parentDocument;

    /**
     * Routes (mapped from Route::content).
     *
     * @var \Symfony\Component\Routing\Route[]
     */
    protected $routes;

    /**
     * Get id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get parent document.
     *
     * @return Generic
     */
    public function getParentDocument()
    {
        return $this->parentDocument;
    }

    /**
     * Set parent document.
     *
     * @param Generic $parentDocument
     *
     * @return Blog
     */
    public function setParentDocument(Generic $parentDocument)
    {
        $this->parentDocument = $parentDocument;

        return $this;
    }

    /**
     * Get routes that point to this content.
     *
     * @return \Symfony\Component\Routing\Route[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {
        parent::setName($name);

        $this->slug = PostUtils::slugify($name);

        return $this;
    }
}
