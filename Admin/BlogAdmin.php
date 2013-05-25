<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Symfony\Cmf\Bundle\BlogBundle\Form\PostType;
use Symfony\Cmf\Bundle\BlogBundle\Routing\BlogRouteManager;

/**
 * Blog Admin
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class BlogAdmin extends Admin
{
    protected $translationDomain = 'CmfBlogBundle';
    protected $blogRoot;

    protected function configureFormFields(FormMapper $mapper)
    {
        $mapper->add('name', 'text');
        $mapper->add('parent', 'doctrine_phpcr_odm_tree', array(
            'root_node' => $this->blogRoot, 
            'choice_list' => array(), 
            'select_root_node' => true)
        );
    }

    protected function configureDatagridFilters(DatagridMapper $dm)
    {
        $dm->add('name', 'doctrine_phpcr_string');
    }

    protected function configureListFields(ListMapper $dm)
    {
        $dm->addIdentifier('name');
    }

    public function setBlogRoot($blogRoot)
    {
        $this->blogRoot = $blogRoot;
    }

    public function validate(ErrorElement $ee, $obj)
    {
        $ee->with('name')->assertNotBlank()->end();
    }
}
