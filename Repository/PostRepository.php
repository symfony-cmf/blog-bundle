<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Bundle\BlogBundle\Repository;
use Doctrine\ODM\PHPCR\DocumentRepository;
use Symfony\Cmf\Bundle\BlogBundle\Doctrine\Phpcr\Post;

class PostRepository extends DocumentRepository
{ 
    public function searchQuery($options)
    {
        $options = array_merge(array(
            'blog_uuid' => null,
        ), $options);

        $qb = $this->createQueryBuilder('p');

        if ($options['blog_id']) {
            $qb->where()->descendant($options['blog_id'], 'p');
        }

        $qb->orderBy()->desc()->field('p.publicationDate');

        return $qb->getQuery();
    }

    public function search($options)
    {
        $q = $this->searchQuery($options);
        return $q->execute();
    }
}
