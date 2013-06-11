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
        $qb = $this->createQueryBuilder();

        $criterias = array();

        if ($options['blog_id']) {
            $criterias[] = $qb->expr()->descendant($options['blog_id']);
        }

        if (count($criterias) == 2) {
            $qb->where(
                $qb->expr()->andX($criterias[0], $criterias[1])
            );
        } elseif (count($criterias) == 1) {
            $qb->where(current($criterias));
        }

        $qb->orderBy('date', 'DESC');
        $q = $qb->getQuery();

        return $q;
    }

    public function search($options)
    {
        $q = $this->searchQuery($options);
        $res = $q->execute();
        return $res;
    }
}
