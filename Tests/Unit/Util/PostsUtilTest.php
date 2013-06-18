<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Unit\Util;

use Symfony\Cmf\Bundle\BlogBundle\Util\PostUtils;

class PostsUtilTest extends \PhpUnit_Framework_Testcase
{
    public function dataProviderSlugify()
    {
        return array(
            array('this is a slug', 'this-is-a-slug'),
            array('This Is A SLUG', 'this-is-a-slug'),
            array('je suis une dévelopeur web', 'je-suis-une-developeur-web'),
            array('foo!"  812391 !"£ %!"$£*%!"$£', 'foo-812391'),
            array('ĉràzŷ& cĥärs', 'crazy-chars'),
        );
    }

    /**
     * @dataProvider dataProviderSlugify
     */
    public function testSlugify($val, $expected)
    {
        $res = PostUtils::slugify($val);
        $this->assertEquals($res, $expected);
    }
}
