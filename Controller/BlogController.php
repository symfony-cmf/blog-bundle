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

    protected function getBlog(Request $request)
    {
        $blog = $request->get('_content');

        if (!$blog) {
            throw new NotFoundHttpException('Cannot find content in "_content" parameter');
        }

        if (!$blog instanceof Blog) {
            throw new NotFoundHttpException(sprintf(
                'Content associated with route is not a Blog, is a "%s"', 
                get_class($blog)
            ));
        }

        return $blog;
    }

    // @todo: Not sure how contentDocument and maybe contentTemplate get injected here.
    public function listAction(Request $request, $contentDocument)
    {
        $tag = $request->get('tag', null);

        // @todo: Pagination
        $posts = $this->getPostRepo()->search(array(
            'tag' => $tag,
            'blog_id' => $contentDocument->getId(),
        ));

        $contentTemplate = 'SymfonyCmfBlogBundle:Blog:list.{_format}.twig';

        // @todo: Copy and pasted from ContentBundle::ContentController
        //        I wonder if we can share some code between content-like
        //        bundles.
        $contentTemplate = str_replace(
            array('{_format}', '{_locale}'),
            array($request->getRequestFormat(), $request->getLocale()),
            $contentTemplate
        );

        return $this->renderResponse($contentTemplate, array(
            'blog' => $contentDocument,
            'posts' => $posts,
            'tag' => $tag
        ));
    }
}
