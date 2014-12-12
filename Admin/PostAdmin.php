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
        $mapper
            ->with('dashboard.label_post')
                ->add('title')
                ->add('date', 'datetime', array(
                    'widget' => 'single_text',
                ))
                ->add('bodyPreview', 'textarea')
                ->add('body', 'textarea')
                ->add('blog', 'phpcr_document', array(
                    'class' => $this->blogClass,
                ))
            ->end()
        ;
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
