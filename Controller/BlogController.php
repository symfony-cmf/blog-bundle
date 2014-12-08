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

use Symfony\Cmf\Bundle\BlogBundle\Model\Blog;
use Symfony\Cmf\Bundle\BlogBundle\Repository\BlogRepository;
use Symfony\Cmf\Bundle\BlogBundle\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use FOS\RestBundle\View\ViewHandlerInterface;

/**
 * Blog Controller
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class BlogController extends BaseController
{
    /**
     * @var BlogRepository
     */
    protected $blogRepository;

    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @var \Knp\Component\Pager\Paginator
     */
    protected $paginator;

    /**
     * @var int
     */
    protected $postsPerPage;

    public function __construct(
        EngineInterface $templating,
        SecurityContextInterface $securityContext,
        ViewHandlerInterface $viewHandler = null,
        BlogRepository $blogRepository,
        PostRepository $postRepository,
        $paginator = null,
        $postsPerPage = 0
    ) {
        parent::__construct($templating, $securityContext, $viewHandler);
        $this->blogRepository = $blogRepository;
        $this->postRepository = $postRepository;
        $this->paginator = $paginator;
        $this->postsPerPage = $postsPerPage;
    }

    /**
     * List blogs
     */
    public function listAction(Request $request)
    {
        return $this->renderResponse(
            $this->getTemplateForResponse($request, 'CmfBlogBundle:Blog:list.{_format}.twig'),
            array(
                'blogs' => $this->blogRepository->findAll(),
            )
        );
    }

    /**
     * Blog detail - list posts in a blog, optionally paginated
     */
    public function detailAction(Request $request, Blog $contentDocument, $contentTemplate = null)
    {
        $blog = $contentDocument;

        $posts = $this->postRepository->search(array(
            'blogId' => $blog->getId(),
        ));

        $pager = false;
        if ($this->postsPerPage) {
            $pager = $posts = $this->paginator->paginate(
                $posts,
                $request->query->get('page', 1),
                $this->postsPerPage
            );
        }

        $templateFilename = $pager ? 'detailPaginated' : 'detail';
        $contentTemplate = $this->getTemplateForResponse(
            $request,
            $contentTemplate ?: sprintf('CmfBlogBundle:Blog:%s.{_format}.twig', $templateFilename)
        );

        return $this->renderResponse($contentTemplate, compact('blog', 'posts', 'pager'));
    }

}
