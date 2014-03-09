<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


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
