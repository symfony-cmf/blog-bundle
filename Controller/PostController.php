<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Controller;

use Symfony\Cmf\Bundle\BlogBundle\Document\Post;
use Symfony\Component\HttpFoundation\Request;

/**
 * Post Controller
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class PostController extends BaseController
{
    public function postAction()
    {
        return array(
            'post' => $post,
            'markdown_parser' => $mdParser
        );
    }
}
