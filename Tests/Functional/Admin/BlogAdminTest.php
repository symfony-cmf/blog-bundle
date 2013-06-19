<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Functional\Admin;

use Symfony\Cmf\Component\Testing\Functional\BaseTestCase;

class BlogAdminTest extends BaseTestCase
{
    public function testList()
    {
        $client = $this->createClient();

        $client->request('GET', '/admin/dashboard');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
}
