<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
