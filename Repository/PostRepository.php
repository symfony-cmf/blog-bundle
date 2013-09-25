<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Repository;
use Doctrine\ODM\PHPCR\DocumentRepository;
use Symfony\Cmf\Bundle\BlogBundle\Document\Post;

class PostRepository extends DocumentRepository
{ 
    public function searchQuery($options)
    {
        $options = array_merge(array(
            'blog_uuid' => null,
        ), $options);
        $qb = $this->createQueryBuilder('a');

        if ($options['blog_id']) {
            $qb->where()->descendant($options['blog_id'], 'a');
        }

        $qb->orderBy()->desc()->field('a.date');
        return $qb->getQuery();
    }

    public function search($options)
    {
        $q = $this->searchQuery($options);
        return $q->execute();
    }
}
