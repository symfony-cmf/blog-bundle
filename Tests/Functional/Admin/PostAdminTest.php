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

class PostAdminTest extends BaseTestCase
{
    public function testCreate()
    {
        $crawler = $this->requestRoute('GET', 'admin_cmf_blog_post_create');

        $form = $crawler->selectButton('Create')->form();
        $formPrefix = $this->getAdminFormNamePrefix($crawler);

        $form->setValues(array(
            $formPrefix.'[blog]'        => '/cms/blogs/blog-one',
            $formPrefix.'[title]'       => 'A test post.',
            $formPrefix.'[body]'        => 'the full post content',
            $formPrefix.'[bodyPreview]' => 'the post content preview',
        ));

        $this->client->followRedirects();
        $crawler = $this->client->submit($form);

        $this->assertCount(1, $crawler->filter("html:contains('has been successfully created')"),
            'Expected a success flash message, but none was found.'
        );
    }
}
