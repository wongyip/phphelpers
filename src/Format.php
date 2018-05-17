<?php namespace Wongyip\PHPHelpers;

class Format
{
    /**
     * Turn a string into camel-case style.
     * e.g. "Quick brown-fox jumps over the lazy dog!" >> "quickBrownFoxJumpsOverTheLazyDog"
     * 
     * Note that the default pattern break input into parts with any non-alphanumeric chars, and all such chars will be removed from output.
     * 
     * @param string $string
     * @param string $block_pattern
     * @return string
     */
    static function camelCase($string, $block_pattern = "/[a-z0-9]+/i")
    {
        $string = trim($string);
        $output = '';
        if (preg_match_all($block_pattern, $string, $matches)) {
            foreach ($matches[0] as $part){
                $output .= ucfirst(strtolower(trim($part)));
            }
            return lcfirst($output);
        }
        return strtolower($string);
    }
}