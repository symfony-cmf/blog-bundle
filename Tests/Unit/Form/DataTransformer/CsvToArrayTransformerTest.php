<?php

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
