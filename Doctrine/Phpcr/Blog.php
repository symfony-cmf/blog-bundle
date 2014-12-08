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
use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;
use Doctrine\ODM\PHPCR\Document\Generic;

/**
 * Blog Document
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
     * Parent Document
     *
     * @var Generic
     */
    protected $parent;

    /**
     * Routes (mapped from Route::content)
     *
     * @var \Symfony\Component\Routing\Route[]
     */
    protected $routes;


    /**
     * Constructor
     *
     * @param string $name
     * @param Generic $parent
     */
    public function __construct($name = null, $description = null, Generic $parent = null)
    {
        parent::__construct($name, $description);
        $this->parent = $parent;
    }

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
     * Get parent document
     *
     * @return Generic
     */
    public function getParentDocument()
    {
        return $this->parent;
    }

    /**
     * Set parent document
     *
     * @param Generic $parent
     * @return Blog
     */
    public function setParentDocument(Generic $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get routes that point to this content
     *
     * @return \Symfony\Component\Routing\Route[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}