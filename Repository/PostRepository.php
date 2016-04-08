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
use Symfony\Cmf\Bundle\BlogBundle\Doctrine\Phpcr\Post;

class PostRepository extends DocumentRepository
{
    /**
     * @var OptionsResolver
     */
    protected $resolver;

    /**
     * Constructor.
     *
     * @param \Doctrine\ODM\PHPCR\DocumentManager $dm
     * @param ClassMetadata                       $class
     */
    public function __construct($dm, ClassMetadata $class)
    {
        parent::__construct($dm, $class);
        $this->resolver = $this->setDefaultOptions(new OptionsResolver());
    }

    /**
     * Search for posts by an array of options:
     *   - blogId: string (required)
     *   - isPublishable: boolean (optional, default true) // TODO: https://github.com/symfony-cmf/CoreBundle/issues/126
     *   - title: string (optional)
     *   - limit: integer (optional)
     *   - orderBy: array of arrays('field' => $field, 'order' => 'ASC or DESC') (optional).
     *
     * @param array $options
     *
     * @return Post[]    When limit is not provided or is greater than 1
     * @return Post|null When limit is set to 1
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

    /**
     * Create query builder from search options.
     *
     * @param array $options
     *
     * @return \Doctrine\ODM\PHPCR\Query\Builder\QueryBuilder
     */
    protected function createQueryBuilderFromOptions(array $options)
    {
        $qb = $this->createQueryBuilder('p');

        // parent node (blog id)
        $qb->where()->descendant($options['blogId'], 'p');

        // is published
        if (isset($options['isPublishable']) && ($options['isPublishable'] !== null)) {
            $qb->andWhere()->eq()->field('p.isPublishable')->literal($options['isPublishable']);
        }

        // order by
        if (isset($options['orderBy']['field']) && isset($options['orderBy']['order'])) {
            $field = $options['orderBy']['field'];
            $sortOrder = strtolower($options['orderBy']['order']);

            $qb->orderBy()->$sortOrder()->field('p.'.$field);
        }

        // limit
        if (isset($options['limit'])) {
            $qb->setMaxResults($options['limit']);
        }

        return $qb;
    }

    /**
     * Set default search options.
     *
     * @param OptionsResolver $resolver
     *
     * @return OptionsResolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'isPublishable' => true,
            'orderBy' => array(
                array(
                    'field' => 'date',
                    'order' => 'DESC',
                ),
            ),
        ));

        $resolver->setRequired(array(
            'blogId',
        ));

        $resolver->setOptional(array(
            'isPublishable',
            'limit',
            'title',
        ));

        $resolver->setAllowedTypes(array(
            'isPublishable' => array('null', 'bool'),
            'blogId' => 'string',
            'title' => 'string',
            'limit' => 'int',
            'orderBy' => 'array',
        ));

        return $resolver;
    }
}
