<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Cmf\Bundle\BlogBundle\Document\Blog;
use Doctrine\ODM\PHPCR\DocumentManager;
use FOS\RestBundle\View\View;

/**
 * Blog Controller
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class BlogController
{
    protected $templating;
    protected $viewHandler;
    protected $dm;

    public function __construct(
        EngineInterface $templating, 
        ViewHandlerInterface $viewHandler = null,
        DocumentManager $dm
    ) {
        $this->templating = $templating;
        $this->viewHandler = $viewHandler;
        $this->dm = $dm;
    }

    protected function renderResponse($contentTemplate, $params)
    {
        if ($this->viewHandler) {
            $view = new View($params);
            $view->setTemplate($contentTemplate);
            return $this->viewHandler->handle($view);
        }

        return $this->templating->renderResponse($contentTemplate, $params);
    }

    protected function getPostRepo()
    {
        return $this->dm->getRepository('Symfony\Cmf\Bundle\BlogBundle\Document\Post');
    }

    public function viewPostAction(Request $request, $contentDocument, $contentTemplate = null)
    {
        $post = $contentDocument;
        $prevPost = $this->getPostRepo()->fetchPrevPost($post);
        $nextPost = $this->getPostRepo()->fetchNextPost($post);

        $contentTemplate = $contentTemplate ?: 'CmfBlogBundle:Blog:view_post.html.twig';

        return $this->renderResponse($contentTemplate, array(
            'post' => $post,
            'nextPost' => $nextPost,
            'prevPost' => $prevPost,
        ));
    }

    public function listAction(Request $request, $contentDocument, $contentTemplate = null)
    {
        $blog = $contentDocument;
        $tag = $request->get('tag', null);

        // @todo: Pagination
        $posts = $this->getPostRepo()->search(array(
            'tag' => $tag,
            'blog_id' => $blog->getId(),
        ));

        $contentTemplate = $contentTemplate ?: 'CmfBlogBundle:Blog:list.{_format}.twig';

        // @todo: Copy and pasted from ContentBundle::ContentController
        //        I wonder if we can share some code between content-like
        //        bundles.
        $contentTemplate = str_replace(
            array('{_format}', '{_locale}'),
            array($request->getRequestFormat(), $request->getLocale()),
            $contentTemplate
        );

        return $this->renderResponse($contentTemplate, array(
            'blog' => $blog,
            'posts' => $posts,
            'tag' => $tag
        ));
    }
}
