<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Repository;
use Doctrine\ODM\PHPCR\DocumentRepository;

class PostRepository extends DocumentRepository
{ 
    public function searchQuery($options)
    {
        $options = array_merge(array(
            'tag' => null,
            'blog_uuid' => null,
        ), $options);
        $qb = $this->createQueryBuilder();

        $criterias = array();

        if ($options['tag']) {
            $criterias[] = $qb->expr()->eq('tags', $options['tag']);
        }

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

    public function fetchOneBySlug($slug)
    {
        $qb = $this->createQueryBuilder();
        $qb->where($qb->expr()->eq('slug', $slug));
        $qb->setMaxResults(1);
        $q = $qb->getQuery();
        $post = $q->getSingleResult();

        return $post;
    }
}
