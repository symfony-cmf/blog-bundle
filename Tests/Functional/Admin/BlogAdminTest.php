<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Functional\Admin;

use Symfony\Cmf\Bundle\BlogBundle\Tests\Functional\BaseTestCase;

class BlogAdminTest extends BaseTestCase
{
    public function testList()
    {
        $client = $this->createClient();

        $client->request('GET', '/admin/dashboard');
        $response = $client->getResponse();
        die($response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
}
