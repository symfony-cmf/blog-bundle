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
 * Interface which allows different tagging strategies
 * to be used. With the end goal of making Tags work
 * out of the box with PHPCR, but giving the option
 * to use a database system better tuned for aggregation,
 * e.g. an RDMS.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
interface StrategyInterface
{
    /**
     * Return an associative array of tags as:
     *
     *   array(
     *      'symfony' => array(
     *          'count' => 123
     *          'weight' => 0.6
     *      ),
     *      'php' => array(
     *          'count' => 100
     *          'weight' => 0.4
     *      ),
     *      // etc.
     *   )
     *
     * The weight is a floating point number between 
     * 0 and 1 and represents the relative weight of the
     * tag within the set. It is calculated as:
     *
     *   (tag count sum) / (highest individual tag count sum)
     *
     * @param string $blogId - ID of blog, e.g. /content/blogs/my-blog
     * 
     * @return array
     */
    public function getWeightedTags($blogId);

    /**
     * Give the strategy the chance to update its database
     * of tags.
     *
     * @param Post $post - Blog post
     */
    public function updateTags(Post $post);
}
