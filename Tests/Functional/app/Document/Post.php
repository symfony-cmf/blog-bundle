<?php

namespace Symfony\Cmf\Bundle\ChronologyBundle\Tests\Functional\app\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Bundle\RoutingExtraBundle\Mapping\Annotations as CMFRouting;

/**
 * @PHPCR\Document(
 *      referenceable=true
 * )
 */
class Post
{
    /**
     * @PHPCR\Id()
     */
    public $path;

    /**
     * @PHPCR\Referrers(
     *   referringDocument="Symfony\Cmf\Bundle\RoutingExtraBundle\Document\Route", 
     *   referencedBy="routeContent"
     * )
     */
    public $routes;

    /**
     * @PHPCR\ParentDocument()
     */
    public $blog;

    /**
     * @PHPCR\NodeName()
     */
    public $title;

    public function getTitle()
    {
        return $this->title;
    }

    public function getBlog()
    {
        return $this->blog;
    }

    public function getDate()
    {
        return new \DateTime('2013/03/21');
    }
}
