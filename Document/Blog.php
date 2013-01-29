<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * Blog Document
 *
 * @author Daniel Leech <daniel@dantleech.com>
 *
 * @PHPCR\Document()
 */
class Blog
{
    /**
     * @PHPCR\Id()
     */
    protected $id;

    /**
     * @PHPCR\Name()
     */
    protected $name;

    /**
     * @PHPCR\Parent()
     */
    protected $parent;

    /**
     * @PHPCR\Children()
     */
    protected $children;

}

