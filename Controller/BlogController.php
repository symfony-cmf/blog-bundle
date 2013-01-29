<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blog Controller
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class BlogController extends BaseController
{
    public function renderAction(Request $request)
    {
        $blog = $this->get('request')->get('_endpoint');
        $posts = $this->getPostRepo()->search(array(
            'tag' => $tag = $request->get('tag'),
            'blog_uuid' => $blog->getUuid(),
        ));

        return array(
            'blog' => $blog,
            'posts' => $posts,
            'tag' => $tag
        );
    }
}

