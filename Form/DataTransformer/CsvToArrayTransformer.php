<?php

namespace Symfony\Cmf\Bundle\BlogBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * CSV (comma separated value) to array transformer
 *
 * Transforms a list of values delimited by "," into
 * an array of values and vice-versa.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class CsvToArrayTransformer implements DataTransformerInterface
{
    /**
     * Transforms an array of values to a comma
     * separated string.
     *
     * @param array $value
     *
     * @return string
     */
    public function transform($value)
    {
        if ($value) {

            // trim all the values
            $value = array_map('trim', $value);

            // join together
            $string = implode(',', $value);

            return $string;
        }
    }

    /**
     * Transforms a CSV string into an array.
     *
     * @param  string $value
     *
     * @return array
     */
    public function reverseTransform($value)
    {
        if ($value) {

            // string to array
            $array = explode(',', $value);

            // trim all the values
            $array = array_map('trim', $array);

            return $array;
        }
    }
}


