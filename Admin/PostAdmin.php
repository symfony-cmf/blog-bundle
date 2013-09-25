<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Symfony\Cmf\Bundle\BlogBundle\Form\PostType;
use Symfony\Cmf\Bundle\BlogBundle\Form\DataTransformer\CsvToArrayTransformer;

/**
 * Post Admin
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class PostAdmin extends Admin
{
    protected $translationDomain = 'CmfBlogBundle';

    protected function configureFormFields(FormMapper $mapper)
    {
        // @todo: I think this would be better as a service,
        //        but I don't know how integrate the form
        //        AND have all the Sonata magic from the
        //        FormMapper->add method.

        // $csvToArrayTransformer = new CsvToArrayTransformer;

        $mapper->add('title');
        $mapper->add('date', 'datetime', array(
            'widget' => 'single_text',
        ));

        $mapper->add('body', 'textarea');
        $mapper->add('blog', 'phpcr_document', array(
            'class' => 'Symfony\Cmf\Bundle\BlogBundle\Document\Blog',
        ));

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

    public function validate(ErrorElement $ee, $obj)
    {
        $ee->with('title')->assertNotBlank()->end();
    }
}
