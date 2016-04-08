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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;

/**
 * Base Controller.
 */
abstract class BaseController
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var ViewHandlerInterface
     */
    protected $viewHandler;

    /**
     * Constructor.
     *
     * @param EngineInterface          $templating
     * @param SecurityContextInterface $securityContext
     * @param ViewHandlerInterface     $viewHandler
     */
    public function __construct(
        EngineInterface $templating,
        SecurityContextInterface $securityContext,
        ViewHandlerInterface $viewHandler = null
    ) {
        $this->templating = $templating;
        $this->securityContext = $securityContext;
        $this->viewHandler = $viewHandler;
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

    protected function getTemplateForResponse(Request $request, $contentTemplate)
    {
        return str_replace(
            array('{_format}', '{_locale}'),
            array($request->getRequestFormat(), $request->getLocale()),
            $contentTemplate
        );
    }
}
