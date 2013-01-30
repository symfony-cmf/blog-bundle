<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tagging;

/**
 * Tagging strategy that uses the Doctrine ORM
 * to store tags which should improve performance
 * with tag aggregation.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class DoctrineORMStrategy implements StrategyInterface
{
    public function getWeightedTags($blogId)
    {
        // select aggregated tag counts...
        // @todo.
    }

    public function updateTags(Post $post)
    {
        foreach ($post->getTags() as $tag) {
            // todo
        }
    }
}
