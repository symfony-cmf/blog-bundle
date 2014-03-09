<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Bundle\BlogBundle\Block;

use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Cmf\Bundle\BlogBundle\Repository\TagRepository;

/**
 * Tag Cloud block service
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class TagCloudBlockService extends BaseBlockService
{
    protected $repo;

    public function __construct($name, EngineInterface $templating, TagRepository $repo)
    {
        $this->repo = $repo;
        parent::__construct($name, $templating);
    }

    public function getDefaultSettings()
    {
        return array(
            'path' => 'cmf_blog_post_index'
        );
    }

    public function buildEditForm(FormMapper $fm, BlockInterface $block)
    {
    }

    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    public function execute(BlockInterface $block, Response $response = null)
    {
        $wTags = $this->repo->getWeightedTags();
        return $this->renderResponse('CmfBlogBundle:Block:tagCloud.html.twig', array(
            'block' => $block,
            'wTags' => $wTags
        ));
    }
}
