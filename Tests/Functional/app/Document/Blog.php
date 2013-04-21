<?php

namespace Symfony\Cmf\Bundle\ChronologyBundle\Tests\Functional\app\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Bundle\RoutingExtraBundle\Mapping\Annotations as CMFRouting;

/**
 * @PHPCR\Document(
 *      referenceable=true
 * )
 */
class Blog
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
     * @PHPCR\String()
     */
    public $title;

    public function getTitle()
    {
        return $this->title;
    }
}

