<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Unit\Form\DataTransformer;

use Symfony\Cmf\Bundle\BlogBundle\Form\DataTransformer\CsvToArrayTransformer;

class CsvToArrayTransformerTest extends \PhpUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->transformer = new CsvToArrayTransformer;
    }

    public function testTransform()
    {
        $v = array('one', 'two', 'three  ', 'four five');
        $res = $this->transformer->transform($v);

        $this->assertEquals('one,two,three,four five', $res);
    }

    public function testReverseTransform()
    {
        $v = ' one, one,  two,  three  ,  four five ';
        $res = $this->transformer->reverseTransform($v);

        $expected = array('one', 'one', 'two', 'three', 'four five');
        $this->assertEquals($expected, $res);
    }
}
