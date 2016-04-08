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
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;

/**
 * Blog Admin.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class BlogAdmin extends Admin
{
    protected $translationDomain = 'CmfBlogBundle';
    protected $blogRoot;

    /**
     * Constructor.
     *
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     * @param string $blogRoot
     */
    public function __construct($code, $class, $baseControllerName, $blogRoot)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->blogRoot = $blogRoot;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('dashboard.label_blog')
                ->add('name', 'text')
                ->add('description', 'textarea')
                ->add('parentDocument', 'doctrine_phpcr_odm_tree', array(
                    'root_node' => $this->blogRoot,
                    'choice_list' => array(),
                    'select_root_node' => true,
                ))
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('name', 'doctrine_phpcr_string')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
        ;
    }
}
