<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Symfony\Cmf\Bundle\BlogBundle\Form\PostType;

/**
 * Post Controller
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class PostAdmin extends Admin
{
    protected function configureFormFields(FormMapper $mapper)
    {
        // @todo: Move this to a didicated form class and service?
        //        (easier handling of dependencies)
        $mapper->add('title');
        $mapper->add('date', 'datetime', array(
            'widget' => 'single_text',
        ));
        $mapper->add('status', 'choice', array(
            'choices' => array(
                'draft' => 'Draft',
                'published' => 'Published',
            ),
        ));
        $mapper->add('body', 'dcms_markdown_textarea', array(
            'preview' => false,
        ));
        $mapper->add('blog', 'phpcr_document', array(
            'class' => 'DCMS\Bundle\BlogBundle\Document\BlogEndpoint',
        ));
        $mapper->add('csvTags');
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

    public function validate(ErrorElement $ee, $obj)
    {
        $ee->with('title')->assertNotBlank()->end();
    }
}

?>
