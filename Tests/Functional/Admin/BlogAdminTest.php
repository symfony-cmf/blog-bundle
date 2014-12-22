<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Functional\Admin;

use Symfony\Cmf\Bundle\BlogBundle\Tests\Functional\BaseTestCase;

class BlogAdminTest extends BaseTestCase
{
    public function testCreate()
    {
        $crawler = $this->requestRoute('GET', 'admin_cmf_blog_blog_create');

        $form = $crawler->selectButton('Create')->form();
        $formPrefix = $this->getAdminFormNamePrefix($crawler);

        $form->setValues(array(
            $formPrefix.'[name]'           => 'Test Blog',
            $formPrefix.'[description]'    => 'A blog lives here.',
            $formPrefix.'[parentDocument]' => '/cms/test',
        ));

        $this->client->followRedirects();
        $crawler = $this->client->submit($form);

        $this->assertCount(1, $crawler->filter("html:contains('has been successfully created')"),
            'Expected a success flash message, but none was found.'
        );
    }
}
