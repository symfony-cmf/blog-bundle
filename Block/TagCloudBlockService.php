<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Block;

use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Cmf\Bundle\BlogBundle\Tagging\StrategyInterface;

/**
 * Tag Cloud block service
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class TagCloudBlockService extends BaseBlockService
{
    protected $strategy;

    public function __construct($name, EngineInterface $templating, StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
        parent::__construct($name, $templating);
    }

    public function getDefaultSettings()
    {
        return array(
            'descendants_of' => '/'
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
        $settings = array_merge($this->getDefaultSettings(), $block->getSettings());
        $weightedTags = $this->strategy->getWeightedTags($settings['descendants_of']);

        return $this->renderResponse('SymfonyCmfBlogBundle:Block:tag_cloud.html.twig', array(
            'block' => $block,
            'weightedTags' => $weightedTags
        ));
    }
}
