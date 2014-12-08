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
use Doctrine\ODM\PHPCR\Mapping\ClassMetadata;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Cmf\Bundle\BlogBundle\Doctrine\Phpcr\Blog;

class BlogRepository extends DocumentRepository
{
    /**
     * @var OptionsResolver
     */
    protected $resolver;

    /**
     * @var string
     */
    protected $basepath;

    /**
     * Constructor
     *
     * @param \Doctrine\ODM\PHPCR\DocumentManager $dm
     * @param ClassMetadata $class
     */
    public function __construct($dm, ClassMetadata $class)
    {
        parent::__construct($dm, $class);
        $this->resolver = $this->setDefaultOptions(new OptionsResolver());
    }

    public function setBasepath($basepath)
    {
        $this->basepath = $basepath;
    }

    /**
     * Find post by name
     *
     * @param string $name
     * @return null|Blog
     */
    public function findByName($name)
    {
        return $this->search(array(
            'name' => $name,
            'limit' => 1,
        ));
    }

    /**
     * Search for posts by an array of options
     *
     * @param array $options
     * @return Blog[] When limit is not provided or is greater than 1
     * @return Blog|null When limit is set to 1
     */
    public function search(array $options)
    {
        $options = $this->resolver->resolve($options);

        $qb = $this->createQueryBuilderFromOptions($options);

        if (isset($options['limit']) && $options['limit'] === 1) {
            return $qb->getQuery()->getOneOrNullResult();
        }

        return $qb->getQuery()->getResult();
    }

    protected function createQueryBuilderFromOptions(array $options)
    {
        $qb = $this->createQueryBuilder('b');

        // parent node
        $qb->where()->descendant($this->basepath, 'b');

        // blog name
        if (isset($options['name'])) {
            $qb->andWhere()->eq()->field('b.name')->literal($options['name']);
        }

        // order by
        $qb->orderBy()->asc()->field('b.name');

        // limit
        if (isset($options['limit'])) {
            $qb->setMaxResults($options['limit']);
        }

        return $qb;
    }

    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setOptional(array(
            'limit',
            'name',
        ));

        // null types mean don't include / search by the key term
        $resolver->setAllowedTypes(array(
            'name' => 'string',
            'limit' => 'int',
        ));

        $resolver->setAllowedValues(array(
            'limit' => function($value) {
                return $value > 0;
            },
        ));

        return $resolver;
    }

}
