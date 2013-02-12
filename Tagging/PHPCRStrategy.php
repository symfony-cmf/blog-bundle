<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tagging;

use Symfony\Cmf\Bundle\BlogBundle\Repository\PostRepository;

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

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    /**
     * {@inheritDoc}
     */
    public function getWeightedTags($blogId)
    {
        $tags = $this->postRepo->getTagsForPath($blogId);

        $max = 0;
        $weightedTags = array();

        foreach ($tags as $tag) {
            if (!isset($weightedTags[$tag])) {
                $weightedTags[$tag] = array(
                    'count' => 0,
                );
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
