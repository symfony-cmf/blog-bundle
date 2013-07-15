<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Controller;

use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Cmf\Bundle\BlogBundle\Document\Post;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishWorkflowChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Templating\EngineInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;

/**
 * Blog Controller
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class BlogController
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var ViewHandlerInterface
     */
    protected $viewHandler;

    /**
     * @var DocumentManager
     */
    protected $dm;

    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * The permission to check for when doing the publish workflow check.
     *
     * @var string
     */
    private $publishWorkflowPermission = PublishWorkflowChecker::VIEW_ATTRIBUTE;


    public function __construct(
        EngineInterface $templating,
        ViewHandlerInterface $viewHandler = null,
        DocumentManager $dm,
        SecurityContextInterface $securityContext
    ) {
        $this->templating = $templating;
        $this->viewHandler = $viewHandler;
        $this->dm = $dm;
        $this->securityContext = $securityContext;
    }

    /**
     * What attribute to use in the publish workflow check. This typically
     * is VIEW or VIEW_ANONYMOUS.
     *
     * @param string $attribute
     */
    public function setPublishWorkflowPermission($attribute)
    {
        $this->publishWorkflowPermission = $attribute;
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

    public function viewPostAction(Post $contentDocument, $contentTemplate = null)
    {
        $post = $contentDocument;

        if (true !== $this->securityContext->isGranted($this->publishWorkflowPermission, $post)) {
            throw new NotFoundHttpException(sprintf(
                'Post "%s" is not published'
            , $post->getTitle()));
        }

        $contentTemplate = $contentTemplate ? : 'CmfBlogBundle:Blog:view_post.html.twig';

        return $this->renderResponse($contentTemplate, array(
            'post' => $post,
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
