<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Bundle\BlogBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Symfony\Cmf\Bundle\BlogBundle\Form\DataTransformer\CsvToArrayTransformer;

/**
 * Post Admin
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class PostAdmin extends Admin
{
    protected $translationDomain = 'CmfBlogBundle';
    protected $blogClass;

    /**
     * Constructor
     *
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     * @param string $blogClass
     */
    public function __construct($code, $class, $baseControllerName, $blogClass)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->blogClass = $blogClass;
    }

    protected function configureFormFields(FormMapper $mapper)
    {
        // @todo: I think this would be better as a service,
        //        but I don't know how integrate the form
        //        AND have all the Sonata magic from the
        //        FormMapper->add method.

        // $csvToArrayTransformer = new CsvToArrayTransformer;

        $mapper
            ->with('dashboard.label_post')
                ->add('title')
                ->add('publicationDate', 'datetime', array(
                    'widget' => 'single_text',
                ))
                ->add('content', 'textarea')
                ->add('blog', 'phpcr_document', array(
                    'class' => $this->blogClass,
                ))
            ->end()
        ;

        //$tags = $mapper->create('tags', 'text')
        //    ->addModelTransformer($csvToArrayTransformer);

        // $mapper->add($tags);
    }

    protected function configureDatagridFilters(DatagridMapper $dm)
    {
        $dm->add('title', 'doctrine_phpcr_string');
    }

    protected function configureListFields(ListMapper $dm)
    {
        $dm->add('blog');
        $dm->add('date', 'datetime');
        $dm->addIdentifier('title');
    }

}
