<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Util;

/**
 * Miscilaneous reuseable code
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class PostUtils
{
    /**
     * @todo: I wonder if this should be pushed back
     *        to some cmf/commons library.
     */
    public static function slugify($string)
    {
        // internationally safe slugs
        setlocale(LC_CTYPE, 'fr_FR.UTF8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $clean = strip_tags($clean);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

        if (substr($clean, -1) == '-') {
            $clean = substr($clean, 0, -1);
        }

        return $clean;
    }
}
