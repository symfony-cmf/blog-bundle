<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tagging;

use Symfony\Cmf\Bundle\BlogBundle\Repository\PostRepository;
use Symfony\Cmf\Bundle\BlogBundle\Repository\BlogRepository;

/**
 * Tagging strategy that uses the native
 * multivalue string property of the blog post
 * and aggregates weighted tags with PHP.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class PHPCRStrategy implements StrategyInterface
{
    protected $postRepo;
    protected $blogRepo;

    public function __construct(BlogRepository $blogRepo,  PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
        $this->blogRepo = $blogRepo;
    }

    /**
     * {@inheritDoc}
     */
    public function getWeightedTags($blogId)
    {
        $blog = $this->blogRepo->find($blogId);

        if (!$blog) {
            throw new \Exception(sprintf(
                'Cannot find blog at "%s"',
                $blogId
            ));
        }

        $tags = $this->postRepo->getTagsForBlog($blog);

        $max = 0;
        $weightedTags = array();

        foreach ($tags as $tag) {
            if (!isset($weightedTags[$tag])) {
                $weightedTags[$tag] = array(
                    'count' => 0,
                );
                $weightedTags[$tag]['object'] = new Tag($blog, $tag);
            }

            $weightedTags[$tag]['count']++;

            if ($weightedTags[$tag]['count'] > $max) {
                $max = $weightedTags[$tag]['count'];
            }
        }

        foreach ($weightedTags as $name => &$tag) {
            $tag['weight'] = round($tag['count'] / $max, 2);
        }

        return $weightedTags;
    }
}
