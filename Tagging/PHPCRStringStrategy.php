<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tagging;

/**
 * Tagging strategy that uses the native
 * multivalue string property of the blog post
 * and aggregates weighted tags with PHP.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class PHPCRStringStrategy implements StrategyInterface
{
    /**
     * {@inheritDoc}
     */
    public function getWeightedTags($blogId)
    {
        $qb = $this->postRep->createQueryBuilder('a');
        $qb->select('tags');
        $qb->where()->descendant($blogId, 'a'); // select only children of given blog
        $q = $qb->getQuery();
        $res = $q->getPhpcrNodeResult();
        $rows = $res->getRows();
        $weightedTags = array();

        $max = 0;
        foreach ($rows as $row) {
            $tag = $row->getValue('tags');
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
            $tag['weight'] = $tag['count'] / $max;
        }

        return $weightedTags;
    }
}
