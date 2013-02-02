<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Symfony\Cmf\Bundle\BlogBundle\Form\PostType;

/**
 * Blog Admin
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class BlogAdmin extends Admin
{
    protected $blogRoot;

    protected function configureFormFields(FormMapper $mapper)
    {
        $mapper->add('parent', 'doctrine_phpcr_type_tree_model', array(
            'root_node' => $this->blogRoot, 
            'choice_list' => array(), 
            'select_root_node' => true)
        );

        $mapper->add('name', 'text');
    }

    protected function configureDatagridFilters(DatagridMapper $dm)
    {
        $dm->add('title', 'doctrine_phpcr_string');
    }

    protected function configureListFields(ListMapper $dm)
    {
        $dm->addIdentifier('title');
        $dm->add('status');
        $dm->add('blog');
        $dm->add('updatedAt');
    }

    public function setBlogRoot($blogRoot)
    {
        $this->blogRoot = $blogRoot;
    }

    public function validate(ErrorElement $ee, $obj)
    {
        $ee->with('title')->assertNotBlank()->end();
    }
}

?>
