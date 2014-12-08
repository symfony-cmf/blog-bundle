<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Bundle\BlogBundle\Controller;

use Symfony\Cmf\Bundle\BlogBundle\Model\Post;
use Symfony\Cmf\Bundle\BlogBundle\Repository\PostRepository;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishWorkflowChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use FOS\RestBundle\View\ViewHandlerInterface;

/**
 * Post Controller
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class PostController extends BaseController
{
    /**
     * @var PostRepository
     */
    protected $postRepository;

    public function __construct(
        EngineInterface $templating,
        SecurityContextInterface $securityContext,
        ViewHandlerInterface $viewHandler = null,
        PostRepository $postRepository
    ) {
        parent::__construct($templating, $securityContext, $viewHandler);
        $this->postRepository = $postRepository;
    }

    public function detailAction(Request $request, Post $contentDocument, $contentTemplate = null)
    {
        $post = $contentDocument;

        if (true !== $this->securityContext->isGranted(PublishWorkflowChecker::VIEW_ATTRIBUTE, $post)) {
            throw new NotFoundHttpException(sprintf(
                'Post "%s" is not published',
                $post->getTitle()
            ));
        }

        $contentTemplate = $this->getTemplateForResponse(
            $request,
            $contentTemplate ?: 'CmfBlogBundle:Post:detail.{_format}.twig'
        );

        return $this->renderResponse($contentTemplate, compact('post'));
    }

}
